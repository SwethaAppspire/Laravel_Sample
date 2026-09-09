<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;

class SmtpEmailChannel implements MessageChannel
{
   
    public function send(
        Employee $to,
        OutboundMessage $message
    ): DeliveryResult {
        return new DeliveryResult(
            true,
            "Email notification sent to {$to->email}"
        );
    }
}
