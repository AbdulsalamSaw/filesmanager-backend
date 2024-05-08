<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use App\Models\User;


class FileImported extends Model
{
    protected $table = 'file_importeds';
    protected $fillable = ['download_date', 'user_id', 'file_id', 'manager_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
   

}

