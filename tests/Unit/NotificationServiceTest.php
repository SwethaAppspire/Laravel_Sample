<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Contracts\MessageChannel;
use App\Messaging\DeliveryResult;
use App\Messaging\OutboundMessage;
use App\Models\Employee;

class NotificationServiceTest extends TestCase
{
    public function test_fake_channel(): void
    {
        $fake = new class implements MessageChannel {
            public function send (
                Employee $to,
                OutboundMessage $message
            ): DeliveryResult {
                return new DeliveryResult(true, 'Fake notification sent');
            }
        };

        $this->app->instance(MessageChannel::class, $fake);
        $channel = $this->app->make(MessageChannel::class);
       
        $this->assertInstanceOf(MessageChannel::class, $channel);
    }
}