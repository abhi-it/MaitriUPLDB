<?php

namespace App\Models;

use App\Models\API\Servicerequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestFeedback extends Model
{
    use HasFactory;

    protected $table = "service_request_feedbacks";
    
    protected $fillable = [
        'service_request_id',
        'farmer_id',
        'maitri_id',
        'rating',
        'description',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(Servicerequest::class, 'service_request_id');
    }

    public function farmer()
    {
        return $this->belongsTo(FarmerUser::class, 'farmer_id');
    }

    public function maitri()
    {
        return $this->belongsTo(Maitri::class, 'maitri_id');
    }
}