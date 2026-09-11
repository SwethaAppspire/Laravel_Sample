<?php 
namespace Acme\ActivityLog;

use Acme\ActivityLog\Contracts\ActivityLogger;

class DatabaseActivityLogger implements ActivityLogger
{
    public function log(
        string $event,
        string $description,
        ?int $userId = null
    ): void {
        \DB::table(config('activity-log.table'))->insert([
            'event' => $event,
            'description' => $description,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}