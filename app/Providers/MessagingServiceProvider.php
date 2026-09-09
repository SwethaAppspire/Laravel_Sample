<?php

namespace App\Providers;

use App\Messaging\TwilioSmsChannel;
use App\Contracts\MessageChannel;
use App\Messaging\LogChannel;
use Illuminate\Support\ServiceProvider;

class MessagingServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        if ($this->app->environment(['local', 'testing'])) {
            $this->app->bind(
                MessageChannel::class,
                LogChannel::class
            );
        }

         $this->app->when(TwilioSmsChannel::class)
        ->needs('$sid')
        ->giveConfig('services.twilio.sid');

        $this->app->when(TwilioSmsChannel::class)
            ->needs('$token')
            ->giveConfig('services.twilio.token');

        $this->app->when(TwilioSmsChannel::class)
            ->needs('$from')
            ->giveConfig('services.twilio.from');
    }
 
    public function boot(): void
    {
        //
    }
}
