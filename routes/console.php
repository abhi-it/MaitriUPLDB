<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\MaitriDetail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $maitriDetails = MaitriDetail::with('district')->get();

    // Access the district data for each MaitriDetail
    foreach ($maitriDetails as $maitriDetail) {
        $districtName = $maitriDetail->district->name_hindi; // Replace 'name' with the actual column name in the District table
        // Do something with the district data
        return false;

    }
    $this->comment(($districtName));
})->purpose('Display an inspiring quote');
