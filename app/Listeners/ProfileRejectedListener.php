<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Notifications\ProfileRejected;
use App\Profile;

class ProfileRejectedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle($event)
    {
        // get post owner
        $profileOwner = User::where('id', $event->id)->get();

        // build profile verification event
        $verificationEvent = ['user' => $event->username,'message' => 'Your profile rejected'];

        // send notification
        $profileOwner->user->notify(new ProfileRejected($verificationEvent));
    }
}
