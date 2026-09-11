<?php

namespace Acme\ActivityLog;

use Illuminate\Support\Facades\Facade;
use Acme\ActivityLog\Contracts\ActivityLogger;

class ActivityLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogger::class;
    }
}