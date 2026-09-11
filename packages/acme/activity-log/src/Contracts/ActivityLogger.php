<?php

namespace Acme\ActivityLog\Contracts;


interface ActivityLogger
{
    public function log(
        string $event,
        string $description,
        ?int $userId = null
    ): void;
}