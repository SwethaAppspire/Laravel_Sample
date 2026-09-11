<?php
namespace Acme\ActivityLog;

use Acme\ActivityLog\Commands\PruneActivityLogs;
use Acme\ActivityLog\Contracts\ActivityLogger;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/activity-log.php',
            'activ ity-log'
        );
        $this->app->singleton(
            ActivityLogger::class,
            DatabaseActivityLogger::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); 
        
        $this->publishes([
            __DIR__.'/../config/activity-log.php' => config_path('activity-log.php'),
        ], 'activity-log-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PruneActivityLogs::class,
            ]);
        }
    }
}