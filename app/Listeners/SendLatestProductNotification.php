<?php

namespace App\Listeners;

use App\Events\LatestProduct;
use App\Jobs\SendLatestProductMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\user;
use Illuminate\Support\Facades\Bus;

class SendLatestProductNotification
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
    public function handle(LatestProduct $event): void
    {
        $users = User::all();

        $jobs  = $users->map(function($user) use ($event) {
            return new SendLatestProductMail($user, $event->product);
        });
        
        Bus::batch($jobs)->dispatch();
    }
}
