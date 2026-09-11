<?php

namespace App\Observers;

use App\Models\LeaveRequest;
use Acme\ActivityLog\ActivityLog;

class LeaveRequestObserver
{
   
    public function created(LeaveRequest $leaveRequest): void
    {
        
    }

    /**
     * Handle the LeaveRequest "updated" event.
     */
    public function updated(LeaveRequest $leaveRequest): void
    {
        if ($leaveRequest->wasChanged('status')) {
            ActivityLog::log(
                'leave_request.status_changed',
                "Leave request #{$leaveRequest->id} status changed to {$leaveRequest->status}",
                auth()->id()
            );
        }
    }

    /**
     * Handle the LeaveRequest "deleted" event.
     */
    public function deleted(LeaveRequest $leaveRequest): void
    {
        //
    }

    /**
     * Handle the LeaveRequest "restored" event.
     */
    public function restored(LeaveRequest $leaveRequest): void
    {
        //
    }

    /**
     * Handle the LeaveRequest "force deleted" event.
     */
    public function forceDeleted(LeaveRequest $leaveRequest): void
    {
        //
    }
}
