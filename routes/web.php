<?php

use App\Models\Employee;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreEmployeeRequest;

Route::get('/', function () {
    return 'Hello swetha';
});
Route::get('/leave-request', [LeaveRequestController::class, 'index']);
Route::post('/leave-request', [LeaveRequestController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employee model binding
Route::get('/employees/{employee}', function (Employee $employee) {
    return $employee->name;
});

// FormRequest validation
Route::post('/employees', function (StoreEmployeeRequest $request) {
    return response()->json([
        'message' => 'Employee data is valid'
    ]);
});

require __DIR__.'/auth.php';