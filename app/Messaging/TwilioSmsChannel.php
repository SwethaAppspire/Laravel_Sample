<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;
use Illuminate\Http\Client\Factory;

class TwilioSmsChannel implements MessageChannel
{
    public function __construct(
        private Factory $http,
        private string $sid,
        private string $token,
        private string $from,
    ) {
    }
    
    public function send(
        Employee $to,
        OutboundMessage $message
    ): DeliveryResult {

        if (!$this->sid || !$this->token || !$this->from) {
        return new DeliveryResult(
            false,
            'Twilio configuration is missing'
        );
    }

    $this->http->withBasicAuth($this->sid, $this->token)
        ->asForm()
        ->post(
            "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json",
            [
                'From' => $this->from,
                'To' => $to->phone,
                'Body' => $message->message,
            ]
        );

        return new DeliveryResult(
            true,
            "SMS notification sent to {$to->phone}"
        );
    }

}
