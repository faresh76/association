<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['folder_id', 'user_id', 'name', 'path', 'type', 'size'];

    public function folder() {
        return $this->belongsTo(Folder::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
