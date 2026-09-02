<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('billing:send-reminders')
    ->dailyAt('09:00')
    ->withoutOverlapping();

Schedule::command(
    'billing:close-month ' . now()->subMonth()->format('Y-m')
)
    ->monthlyOn(1, '00:05')
    ->withoutOverlapping();