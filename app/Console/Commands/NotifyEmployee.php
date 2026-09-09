<?php

namespace App\Console\Commands;

use App\Messaging\NotificationService;
use App\Models\Employee;
use Illuminate\Console\Command;

class NotifyEmployee extends Command
{
    protected $signature = 'notify:employee {id} {message}';
    protected $description = 'Send a notification to an employee';

    public function handle(NotificationService $notificationService): int
    {
        $employee = Employee::find($this->argument('id'));

        if(!$employee) {
            $this->error('Employee not found.');

            return self::FAILURE;
        }

        $message = $this->argument('message');
        $result = $notificationService->notify(
            $employee,
            $message
        );

        if ($result->success) {
            $this->info($result->message);

            return self::SUCCESS;
        }

        $this->error($result->message);
        return self::FAILURE;
    }
}
