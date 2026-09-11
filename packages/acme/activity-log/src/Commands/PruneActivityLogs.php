<?php

namespace Acme\ActivityLog\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneActivityLogs extends Command
{
    protected $signature = 'activity-log:prune {--days=90}';

    protected $description = 'Delete old activity logs';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $deleted = DB::table('activity_logs')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Deleted {$deleted} old activity logs.");

        return self::SUCCESS;
    }
}