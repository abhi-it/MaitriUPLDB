<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictMapData extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_en',
        'district_hi',
        'breedable_cattle',
        'breedable_extic_cattle',
        'breeable_buffaloes',
        'total_breedable_bovine',
        'total_ait_ids',
    ];
    protected $table = 'district_map_data';
}
