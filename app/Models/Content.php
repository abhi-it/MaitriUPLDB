<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'language', 
        'description',
        'slug', 
        'metatag',
        'content_type',
        'page_no',
        'document',
        'last_date',    
    ];
}
