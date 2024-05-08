<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\FileLocation;

class File extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'id',
        'label',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'user_id',
        'manager_id',
        'hidden',
        'file_written'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function fileLocations()
    {
        return $this->hasMany(FileLocation::class, 'file_id');
    }

}
