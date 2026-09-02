<?php

return [
    'tax_rate' => env('Billing_TAX_RATE', 18),
    'grace_days' => env('BILLING_GRACE_DAYS', 5),
    'reminder_candence_days' => [7, 14, 30],
    'close_day' => env('BILLING_CLOSE_DAY', 1),
];
