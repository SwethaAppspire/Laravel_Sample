<?php

namespace App\Console\Commands;

use Illuminate\Console\ConfirmableTrait;
use App\Models\BillingPeriod;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class CloseBillingMonth extends Command
{
    use ConfirmableTrait;
    protected $signature = 'billing:close-month {period} {--force}';
    protected $description = 'Close a billing month';

    public function handle()
    {
        $period = $this->argument('period');
        
        if(app()->environment('production') && ! $this->option('force')) {
            $this->error(
                'The --force option is required in production.'
            );
            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm(
            "Close billing period {$period}?",
            true
        )) {
            return self::FAILURE;
        }

        $year = substr($period, 0, 4);
        $month = substr($period, 5, 2);

        $alreadyClosed = BillingPeriod::where('period', $period)->exists();

        if ($alreadyClosed) {
            $this->error(
                "Billing period {$period} is already closed."
            );

            return self::FAILURE;
        }

        DB::transaction(function () use ($period, $year, $month) {
          
            Invoice::query()
                ->whereYear('due_on', $year)
                ->whereMonth('due_on', $month)
                ->whereNull('locked_at')
                ->update(['locked_at' => now(),
            ]);


            BillingPeriod::create([
                'period' => $period,
                'closed_at' => now(),
                'closed_by' => 'system:artisan',
            ]);
        });

        $this->info(
            "Billing period {$period} closed successfully."
        );

        return self::SUCCESS;
        
    }
}
