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

        $accepted_notification_types = array(1, 2, 3, 4, 5, 6, 7);

        return collect($array['notifications'])->reject(function ($discourse_notification) {
            return $discourse_notification['read'] || ! in_array($discourse_notification['notification_type'], $accepted_notification_types);
        })->each(function ($discourse_notification) {
            DatabaseNotification::firstOrCreate(
                [
                    'id' => 'dicsourse-'.$discourse_notification['id'],
                ],
                [
                    'type' => '',
                    'notifiable_type' => 'App\User',
                    'notifiable_id' => $this->user->id,
                    'data' => new \App\Services\TransformDiscourseNotification($notification),
                    'read_at' => null,
                ]
            );
        });
    }
}
