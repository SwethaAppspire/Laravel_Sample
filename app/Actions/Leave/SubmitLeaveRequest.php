<?php

namespace App\Actions\Leave;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;

final class SubmitLeaveRequest
{
    public function __invoke(
        Employee $employee,
        array $data
    ): LeaveRequest{
        return DB::transaction(function () use ($employee, $data) {

            $request = $employee->leaveRequest()->create([
                'type' => $data['type'],
                'starts_on' => $data['starts_on'],
                'ends_on' => $data['ends_on'],
                'days' => $data['days'],
                'status' => 'pending',
            ]);

            return $request;
        
        });
        
    }
}