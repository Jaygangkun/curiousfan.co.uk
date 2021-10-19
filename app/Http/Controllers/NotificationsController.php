<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    // only authenticated users
    public function __construct()
    {
        $this->middleware('auth');
    }


    // index
    public function index()
    {
        return view('profile.notifications');
    }

    // mark as read notifications
	public function markAsReadNotifications()
	{
		if (!auth()->check())
            return response()->json(['view' => route('login'), 'lastId' => 0]);

		// mark as read all unreadnotification
		$notifications = auth()->user()->unreadNotifications()->get();

        foreach($notifications as $n){
            $n->markAsRead();
        }

		return response()->json(['updated' => true]);
	}

    // delete all notifications
    public function deleteNotifications()
	{
		if (!auth()->check())
            return response()->json(['view' => route('login'), 'lastId' => 0]);

		// mark as read all unreadnotification
		$notifications = auth()->user()->notifications()->delete();

		return response()->json(['deleted' => true]);
	}
}
