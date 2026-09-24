<?php

namespace App\Console\Commands;

use App\Services\BillingService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyBillsCommand extends Command
{
    protected $signature = 'bills:generate-monthly {--month= : Target month YYYY-MM}';
    protected $description = 'Generate monthly bills for all active society plots and units.';

    public function handle(BillingService $billingService): int
    {
        $month = $this->option('month') ?: now()->format('Y-m');
        
        // Due date: 15th of the month
        $dueDate = Carbon::createFromFormat('Y-m', $month)->day(15)->toDateString();

        $this->info("Initiating billing run for [{$month}] with due date [{$dueDate}]...");

        $res = $billingService->generateMonthlyBills($month, $dueDate);

        $this->table(['Metric', 'Count'], [
            ['Active Properties', $res['total_active']],
            ['Bills Generated', $res['generated']],
            ['Already Existed (Skipped)', $res['skipped']],
        ]);

        $this->info('Completed successfully.');
        return Command::SUCCESS;
    }
}