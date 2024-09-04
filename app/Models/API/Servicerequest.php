<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Servicerequest extends Model
{
    use HasFactory;
    protected $table = 'services_request'; 
    protected $fillable = [
        'user_id',
        'service_name',
        'maitri_id','request_message','status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function maitri(){
        return $this->belongsTo(User::class,'maitri_id','id');
    }

}
