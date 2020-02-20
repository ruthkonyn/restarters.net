<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use JavaScript;
use Cookie;

class NotificationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notification = Auth::user()
        ->unreadNotifications
        ->where('id', $id)
        ->first();

        abort_if( ! $notification, 404);

        $notification->markAsRead();

        unset($_COOKIE['has_notification_cookies_set']); 

        return back()->with('success', 'Notification marked as read');
    }
}
