<?php

use App\Models\BillingPeriod;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('runs send reminders in dry-run mode without sending reminders', function () {
    Invoice::create([
        'customer_name' => 'ABC Company',
        'amount' => 50000,
        'status' => 'unpaid',
        'issued_on' => '2026-07-01',
        'due_on' => '2026-07-15',
    ]);

    $this->artisan('billing:send-reminders', ['--dry-run' => true])
        ->assertSuccessful();

    expect(
        Invoice::first()->locked_at
    )->toBeNull();
});

it('successfully sends reminders for overdue invoices', function () {
    Invoice::create([
        'customer_name' => 'ABC Company',
        'amount' => 50000,
        'status' => 'unpaid',
        'issued_on' => '2026-07-01',
        'due_on' => '2026-07-15',
    ]);

    $this->artisan('billing:send-reminders')
        ->assertSuccessful();
});

it('fails when closing an already closed billing period', function () {
    BillingPeriod::create([
        'period' => '2026-08',
        'closed_at' => now(),
        'closed_by' => 'system:artisan',
    ]);

    $this->artisan('billing:close-month', [
        'period' => '2026-08',
        '--force' =>true,
    ])->assertFailed();

});

it('successfully closes a billing month', function () {
    Invoice::create([
        'customer_name' => 'XYZ Company',
        'amount' => 25000,
        'status' => 'unpaid',
        'issued_on' => '2026-09-01',
        'due_on' => '2026-09-10',
    ]);

    $this->artisan('billing:close-month', [
        'period' => '2026-09',
        '--force' => true,
    ])->assertSuccessful();

    expect(
        Invoice::first()->locked_at
    )->not->toBeNull();

    expect(
        BillingPeriod::where('period', '2026-09')->exists()
    )->toBeTrue();
});