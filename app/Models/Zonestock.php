<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zonestock extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'zone_id',
        'district_id',
        'ai_center_id',
        'maitri_id',
        'location',
        'distributor',
        'item_type',
        'item',
        'species_semen',
        'breed_type',
        'breed',
        'semen_type',
        'bull_id',
        'container_capacity',
        'quantity',
        'scheme',
        'supply_date',
    ];
    protected $table = 'zone_stock_details';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function district()
    {
        return $this->belongsTo(Districts::class, 'district_id');
    }

    public function aiCenter()
    {
        return $this->belongsTo(Latestaicenter::class, 'ai_center_id');
    }

    public function maitri()
    {
        return $this->belongsTo(Manganurodhdata::class, 'maitri_id');
    }

    
}