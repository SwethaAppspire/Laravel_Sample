<?php

namespace App\Messaging;

class DeliveryResult
{
   
    public function __construct(
        public bool $success,
        public string $message
    ) {}
}
