<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemainingStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'dsf_station',
        'breed',
        'supply_date',
        'breed_type',
        'demand_section',
        'semen' ,
        'semen_straws',
        'semen_type' ,
        'banner' ,
        'dangler'  ,
        'standee'  ,
        'pamphlet'  ,
        'ai_kit'  ,
        'container' ,
        'scheme' ,
        'bull_ids',
        'container_capacity',
    ];
    protected $table = 'remaining_stock';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}