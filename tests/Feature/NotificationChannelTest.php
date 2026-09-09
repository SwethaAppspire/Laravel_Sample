<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Contracts\MessageChannel;
use App\Messaging\DeliveryResult;
use App\Messaging\OutboundMessage;
use App\Models\Employee;

class NotificationChannelTest extends TestCase
{
    public function test_message_channel_can_be_swapped(): void
    {
        $fake = new class implements MessageChannel {
            public function send(
                Employee $to,
                OutboundMessage $message
            ): DeliveryResult {
                return new DeliveryResult(
                    true,
                    'Fake notification sent'
                );
            }
        };

        $this->app->instance(MessageChannel::class, $fake);

        $channel = $this->app->make(MessageChannel::class);

        $this->assertInstanceOf(MessageChannel::class, $channel);
        $this->assertSame($fake, $channel);
    }
}