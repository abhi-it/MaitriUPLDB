<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerFeedback extends Model
{
    use HasFactory;

    protected $table = "farmer_feedback";
    protected $fillable = ['user_id', 'insurance', 'feedback'];
}
