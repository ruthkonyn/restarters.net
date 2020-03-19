<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class DiscourseNotificationController extends Controller
{
    /**
     * @var \App\User
     */
    private $user;

    public function __invoke(Request $request)
    {
        // Check here if the user is authenticated
        if ( ! \Cookie::get('authenticated')) {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        $this->user = User::where('email', \Cookie::get('authenticated'))->first();

        if ( ! $this->user) {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        if ( ! \Cookie::get('has_cookie_notifications_set')) {
            $this->handleRequest();
        }

        // 10 Minutes
        \Cookie::queue(\Cookie::make('has_cookie_notifications_set', true, env('NOTIFICATION_COOKIE_LIFETIME', 5), null, '.rstrt.org'));

        $user_notitifications = $this->user->unReadNotifications;

        if (is_null($user_notitifications)) {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        if ( ! $user_notitifications->isEmpty()) {
            $user_notitifications = $user_notitifications->sortBy('created_at')->take(10);
        }

        // Return discourse notifications within the console
        return response()->json([
            'notifications' => $user_notitifications,
            'message' => 'success',
        ]);
    }

    private function handleRequest()
    {
        $client = app('discourse-client');

        $response = $client->request('GET', '/notifications.json', [
            'query' => [
                'username' => $this->user->username,
            ],
        ]);

        if ($response->getStatusCode() != 200 || $response->getReasonPhrase() != 'OK') {
            return response()->json([
                'message' => 'failed',
            ]);
        }

        $array = json_decode($response->getBody()->getContents(), true);

        return collect($array['notifications'])->reject(function ($discourse_notification) {
            return $discourse_notification['read'];
        })->each(function ($discourse_notification) {
            DatabaseNotification::firstOrCreate(
                [
                    'id' => $discourse_notification['id'],
                ],
                [
                    'type' => '',
                    'notifiable_type' => 'App\User',
                    'notifiable_id' => $this->user->id,
                    'data' => [
                        'title' => $discourse_notification['fancy_title'] ?? 'No Title',
                        'name' => $discourse_notification['name'],
                        'url' => $this->generateUrl($discourse_notification),
                    ],
                    'read_at' => null,
                ]
            );
        });
    }
    private function generateUrl(array $discourse_notification)
    {
        $key = array_key_first($discourse_notification['data']);

        $username = $this->user->username;
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
