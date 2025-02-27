<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zone;
class InventoryMap extends Model
{
    use HasFactory;
    protected $fillable = [
        'assign_user_id',
        'user_id',
        'zone_id',
        'inventory_id',
        'deo_id',
        'maitri_id',
    ];
    protected $table = 'inventory_map_user';

    public function zoneStockDetails()
    {
        return $this->belongsTo(Zonestock::class, 'inventory_id', 'id');
    }

    public function deoUser()
    {
        return $this->belongsTo(DeoUser::class, 'deo_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
}