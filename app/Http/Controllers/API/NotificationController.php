<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Notifications\DatabaseNotification;

class notificationController extends Controller
{
    private $client;

    private $response;

    private $notifications_url;

    private $username;

    private $user_id;

    public function __construct()
    {
        $this->client = new Client();

        $this->notifications_url = env('DISCOURSE_URL').'/notifications.json';
    }

    public function __invoke($username, $user_id)
    {
        $this->username = $username;

        $this->user_id = $user_id;

        $collection = $this->handleRequest($username);

        return $collection->toJson();
    }

    private function handleRequest(string $username)
    {
        $response = $this->client->request('GET', $this->notifications_url, [
            'headers' => [
                'Api-Key' => env('DISCOURSE_APIKEY'),
                'Api-Username' => env('DISCOURSE_APIUSER'),
            ],
            'query' => [
                'username' => $username,
            ],
        ]);

        if ( ! $response->getStatusCode() == 200 || ! $response->getReasonPhrase() == 'OK') {
            return false;
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
                    'notifiable_id' => $this->user_id,
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

    public function generateUrl(array $discourse_notification)
    {
        $key = array_key_first($discourse_notification['data']);

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
              "username={$this->username}",
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
