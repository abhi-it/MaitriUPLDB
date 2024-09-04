<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CVOOfficers extends Model
{
    use HasFactory;
    protected $table = 'cvo_vo_officers';
    protected $fillable = [
        'mandal_name',
        'janpad_name', 
        'officer_name',
        'designation', 
        'animal_care_center',
        'mobile_no',
        'lattitute',
        'longitute',
    ];
}
