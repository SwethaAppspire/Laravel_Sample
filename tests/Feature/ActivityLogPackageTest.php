<?php

namespace Tests\Feature;

use Acme\ActivityLog\Contracts\ActivityLogger;
use Acme\ActivityLog\DatabaseActivityLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ActivityLogPackageTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_logger_binding_is_registered(): void
    {
        $logger = app(ActivityLogger::class);

        $this->assertInstanceOf(DatabaseActivityLogger::class, $logger);
    }

    public function test_prune_command_deletes_old_logs_only(): void
    {
        DB::table('activity_logs')->insert([
            'event' => 'old.test',
            'description' => 'Old log',
            'created_at' => now()->subDays(100),
            'updated_at' => now()->subDays(100),
        ]);

        DB::table('activity_logs')->insert([
            'event' => 'recent.test',
            'description' => 'Recent log',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->artisan('activity-log:prune', ['--days' => 90])
            ->expectsOutput('Deleted 1 old activity logs.')
            ->assertSuccessful();

        $this->assertDatabaseMissing('activity_logs', [
            'event' => 'old.test',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'event' => 'recent.test',
        ]);
    }

    public function test_published_config_exists(): void
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'activity-log-config',
            '--force' => true,
        ])->assertSuccessful();

        $this->assertFileExists(config_path('activity-log.php'));
    }
}