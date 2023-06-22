<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\File;
use App\Models\FileLocation;
use App\Models\Department;
use App\Models\PermissionDepartment;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'manager_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function fileLocations()
    {
        return $this->hasMany(FileLocation::class, 'user_id');
    }

   /* public function departments()
    {
        return $this->hasMany(Department::class, 'employee_id');
    }
*/
    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'permission_user_departments', 'user_id', 'department_id')
            ->withPivot('permission_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(PermissionDepartment::class, 'permission_user_departments', 'user_id', 'permission_id')
            ->withPivot('department_id');
    }
}
