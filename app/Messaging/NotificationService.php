<?php

namespace App\Messaging;

use App\Models\Employee;

class NotificationService
{
  
    public function __construct(
        private ChannelResolver $channelResolver
    ) {
    }

    public function notify(
        Employee $employee,
        string $message
    ): DeliveryResult {
        $channel = $this->channelResolver->resolve($employee);

        return $channel->send(
            $employee,
            new OutboundMessage($message)
        );
    }
}
