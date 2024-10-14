<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMap extends Model
{
    use HasFactory;
    protected $fillable = [
        'assign_user_id',
        'user_id',
        'zone_id',
        'inventory_id',
        'deo_id' ,
    ];
    protected $table = 'inventory_map_user';
}
