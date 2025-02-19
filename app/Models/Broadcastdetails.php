<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcastdetails extends Model
{
    use HasFactory;

    protected $table = "broadcast_details";
    protected $fillable = [
        'host_id',
        'stage_arn',
        'participant_count',
    ];
}