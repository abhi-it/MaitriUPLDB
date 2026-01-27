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
        'location',
        'dfs_station',
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
}