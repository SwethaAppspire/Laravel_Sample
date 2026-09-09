<?php

namespace App\Messaging;

class OutboundMessage
{

    public function __construct(
        public string $message
    ) {}
}
