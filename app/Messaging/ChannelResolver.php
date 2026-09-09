<?php

namespace App\Messaging;

use App\Contracts\MessageChannel;
use App\Models\Employee;

class ChannelResolver
{
   
    public function __construct(
        private SmtpEmailChannel $emailChannel,
        private TwilioSmsChannel $smsChannel,
        private LogChannel $logChannel,
    ) {
        
    }

    public function resolve(Employee $employee): MessageChannel
    {
        return match ($employee->preferred_channel){
            'email' => $this->emailChannel,
            'sms' => $this->smsChannel,
            default => $this->logChannel,
        };
    }
}
