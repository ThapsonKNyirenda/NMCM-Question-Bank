<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
       $event->user->update([
           'last_login_at' => Carbon::now(),
           'last_login_ip_address' => request()->getClientIp()
       ]);

       activity()
           ->performedOn($event->user)
           ->causedBy($event->user)
           ->log('The user :subject.name, successfully logged in ');
    }
}
