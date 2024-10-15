<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestData extends Model
{
    use HasFactory;
    protected $fillable = [
        'request_user_id',
        'request_id' ,
        'inventory_id' ,
        'status' ,
    ];
    protected $table = 'request_data_inventory';
    
}
