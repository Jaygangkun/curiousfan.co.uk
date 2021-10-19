<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsRestApiController extends Controller
{

    // only authenticated users
    public function __construct()
    {
        $this->middleware('auth');
    }


    // index
    public function index()
    {

        if (!auth()->check())
        abort(403);

        // get this user notifications
        $notifications = auth()->user()->notifications();

  
        $notifications->where('type', 'All');

        $notifications = $notifications->paginate(10);

        return response()->json($notifications);
    }
}
