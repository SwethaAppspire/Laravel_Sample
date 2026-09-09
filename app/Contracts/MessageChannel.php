<?php

namespace App\Contracts;

use App\Models\Employee;
use App\Messaging\OutboundMessage;
use App\Messaging\DeliveryResult;

interface MessageChannel
{
    public function send(
        Employee $to,
        OutboundMessage $message
    ): DeliveryResult;
}
