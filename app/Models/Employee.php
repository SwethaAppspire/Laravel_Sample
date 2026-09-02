<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'tenant_id',
        'department_id',
        'name',
        'email',
        'joined_on'
    ];

    public function leaveRequest(): Hasmany
    {
        return $this->hasMany(leaveRequest::class);
    }
}
