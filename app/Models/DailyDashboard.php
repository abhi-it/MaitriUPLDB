<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyDashboard extends Model
{
    use HasFactory;
    protected $fillable = [
        'num_of_ai_year',
        'heading_of_ai',
        'num_of_ai',
        'num_of_pd_year',
        'heading_of_pd',
        'num_of_pd',
        'num_of_calving_year',
        'heading_of_calving',
        'num_of_calving',
        'number_of_insurance_year',
        'heading_of_insurance',
        'number_of_insurance',
    ];
    protected $table = 'daily_dashboard';
}
