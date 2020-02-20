<?php

namespace App\Http\Controllers\Discourse;

use App\Http\Controllers\Controller;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class notificationController extends Controller
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var GuzzleHttp\Psr7\Response
     */
    private $response;

    /**
     * @var string
     */
    private $notifications_url;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $user_id;

    public function __construct()
    {
        $this->client = new Client();

        $this->notifications_url = env('DISCOURSE_URL').'/notifications.json';

        //check here if the user is authenticated
        if ( ! Auth::check()) {
            return response()->json([
                'message' => 'failed',
            ]);
        }
    }

    public function __invoke(Request $request, $username = null, $user_id = null)
    {
        if ($username) {
            $this->username = $username;
        }

        if ($user_id) {
            $this->user_id = $user_id;
        }

        if ($_COOKIE['has_cookie_notifications_set']) {
            return response()->json([
                'message' => 'cookies_set',
            ]);
        }

        $collection = $this->handleRequest($username);

        // 10 Minutes
        setcookie('has_cookie_notifications_set', true, time() + (60 * 10), url('/'));

        // Request had failed
        if ($collection instanceof JsonResponse) {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        // Return discourse notifications within the console
        return response()->json([
            'notifications' => $collection,
            'message' => 'success',
        ]);
    }

    private function handleRequest(string $username = null)
    {
        $response = $this->client->request('GET', $this->notifications_url, [
            'headers' => [
                'Api-Key' => env('DISCOURSE_APIKEY'),
                'Api-Username' => env('DISCOURSE_APIUSER'),
            ],
            'query' => [
                'username' => $username ?? Auth::user()->username,
            ],
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() != 200 || $response->getReasonPhrase() != 'OK') {
            return response()->json(['message' => 'failed']);
        }

        $array = json_decode($response->getBody()->getContents(), true);
        $notifications = collect($array['notifications'])->reject(function ($discourse_notification) {
            return $discourse_notification['read'];
        })->each(function ($discourse_notification) {
            DatabaseNotification::firstOrCreate(
                [
                    'id' => $discourse_notification['id'],
                ],
                [
                    'type' => '',
                    'notifiable_type' => 'App\User',
                    'notifiable_id' => $this->user_id ?? Auth::user()->id,
                    'data' => [
                        'title' => $discourse_notification['fancy_title'],
                        'name' => $discourse_notification['name'],
                        'url' => $this->generateUrl($discourse_notification),
                    ],
                    'read_at' => null,
                ]
            );
        });

        $this->response = $notifications;

        return $notifications;
    }

    private function generateUrl(array $discourse_notification)
    {
        $key = array_key_first($discourse_notification['data']);

        $username = Auth::user()->username;
        if ($this->username) {
            $username = $this->username;
        }

        if (str_contains($key, 'topic')) {
            $prepend = 't';
            $slug = sprintf(
                '%s/%s/%s',
                $discourse_notification['slug'],
                $discourse_notification['topic_id'],
                $discourse_notification['post_number']
            );
        }

        if (str_contains($key, 'badge')) {
            $prepend = 'badges';
            $slug = sprintf(
                '%s/%s?',
                $discourse_notification['data']['badge_id'],
                $discourse_notification['data']['badge_slug'],
                "username={$username}"
            );
        }

        $url = sprintf(
            '%s/%s/%s',
            env('DISCOURSE_URL'),
            $prepend,
            $slug
        );

        return $url;
    }
}
