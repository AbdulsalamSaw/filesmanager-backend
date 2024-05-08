<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;
use App\Models\PermissionDepartment;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'manager_id',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(PermissionDepartment::class, 'permission_user_departments', 'department_id', 'permission_id')
            ->withPivot('user_id');
    }
}
