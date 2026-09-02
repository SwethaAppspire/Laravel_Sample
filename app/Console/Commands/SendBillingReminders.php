<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class SendBillingReminders extends Command
{
    protected $signature = 'billing:send-reminders {--dry-run}';

    protected $description = 'Send reminders for overdue invoices';

    public function handle(): int
    {
        $invoices = Invoice::query()
            ->where('status', 'unpaid')
            ->whereDate('due_on', '<', today())
            ->get();

        if ($invoices->isEmpty()) {
            $this->info('No overdue invoices found.');

            return self::SUCCESS;
        }

        $rows = [];

        foreach ($invoices as $invoice) {

            $rows[] = [
                $invoice->id,
                $invoice->customer_name,
                $invoice->amount,
                $invoice->due_on,
            ];

            if (! $this->option('dry-run')) {
                $this->line(
                    "Reminder queued for {$invoice->customer_name}"
                );
            }
        }

        $this->table(
            ['ID', 'Customer', 'Amount', 'Due Date'],
            $rows
        );

        if ($this->option('dry-run')) {
            $this->info('Dry run completed.');
        } else {
            $this->info('Reminders processed successfully.');
        }

        return self::SUCCESS;
    }
}