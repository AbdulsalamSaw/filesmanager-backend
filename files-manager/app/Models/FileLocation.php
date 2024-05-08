<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use App\Models\User;

class FileLocation extends Model
{
    use HasFactory;
    protected $table = 'file_locations';
    protected $fillable = ['room_number', 'cabinet_number','shelf_number','file_written','file_name','file_lable','user_id','file_id', 'manager_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
   
}
