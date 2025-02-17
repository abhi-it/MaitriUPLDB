<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    protected $table = 'webinars';

    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'stage_arn',
    ];
}