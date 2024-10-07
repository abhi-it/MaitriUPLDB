<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeoUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zone_id',
        'division_id',
        'district_id',
        'block_id',
        'aicenters_id',
    ];



    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function division()
    {
        return $this->belongsTo(Divisions::class);
    }

    public function district()
    {
        return $this->belongsTo(Districts::class, 'id', 'name_eng', 'name_hindi');
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function aicenter()
    {
        return $this->belongsTo(Cliniclocation::class, 'aicenters_id', 'id');
    }
}
