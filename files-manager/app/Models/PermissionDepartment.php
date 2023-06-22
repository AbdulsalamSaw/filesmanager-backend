<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;

class PermissionDepartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'permission_id',
        'department_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user_departments', 'permission_id', 'user_id')
            ->withPivot('department_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'permission_user_departments', 'permission_id', 'department_id')
            ->withPivot('user_id');
    }
}
