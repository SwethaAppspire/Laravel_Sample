<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $preferred_channel
 */

class Employee extends Model
{
    protected $fillable = [
        'tenant_id',
        'department_id',
        'name',
        'email',
        'phone',
        'preferred_channel',
        'joined_on'
    ];

    public function leaveRequest(): Hasmany
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
