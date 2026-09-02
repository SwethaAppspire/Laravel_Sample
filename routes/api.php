<?php

use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/leave-requests', [
    LeaveRequestController::class,
    'store',
]);