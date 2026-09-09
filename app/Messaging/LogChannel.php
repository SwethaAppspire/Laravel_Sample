<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class LogChannel implements MessageChannel
{
    
    public function send(
        Employee $to,
        OutboundMessage $message
    ): DeliveryResult {
        Log::info('Employee notification', [
            'employee' => $to->email,
            'message' => $message->message,
        ]);

        return new DeliveryResult(
            true,
            "Notification logged for {$to->email}"
        );
    }
}
