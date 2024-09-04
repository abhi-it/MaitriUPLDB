<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latestupdate extends Model
{
    protected $table = 'latest_update';

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
