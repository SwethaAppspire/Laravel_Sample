<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingPeriod extends Model
{
    protected $fillable = [
        'period',
        'closed_at',
        'closed_by'
    ];
}
