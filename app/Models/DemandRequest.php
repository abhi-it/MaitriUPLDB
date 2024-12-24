<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandRequest extends Model
{
    use HasFactory;
    protected $table = 'demand_requests';
    protected $fillable = [

        'name' ,
        'date_of_birth' ,
        'gender' ,
        'training_center_id' ,
        'bharat_pashudhan_id' ,
        'smart_mobile_no'  ,
        'district' ,
        'mandal',
        'block',
        'vh_ai_center' ,
        'pincode' ,
        'villages_coevring' ,
        'demand_section',
        'semen' ,
        'breed' ,
        'bull_id' ,
        'Sheath' ,
        'gloves' ,
        'animal_tag' ,
        'mineral_mixture' ,
        'dewormer' ,
        'insurance_booklet',
        'pregnancy_feed',
        'calf_starter' ,
        'any_other_item',
        'any_suggestion' ,
        'any_complaint' ,
        'vikas_khand' ,
        'post_office' ,
        'tehsil',
        'semen_type',
        'month',
        'question',
        'semen_source',
        'registered_cow_calves',
        'registered_buffalo_calves',
        'registered_sexed_calves',
        'registered_farmers',
    ];
    public function district(){
        return $this->belongsTo(Districts::class,'district','id');
    }
}
