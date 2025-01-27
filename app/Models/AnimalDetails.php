<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalDetails extends Model
{
    use HasFactory;

    protected $table = "animal_details";
    protected $fillable = ['user_id','breeds','animal_type','cattle_no','milk'];
}
