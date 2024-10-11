<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonestock extends Model
{
    use HasFactory;
    protected $fillable = [
        'demand_section',
        'semen' ,
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
    protected $table = 'zone_stock_details';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
