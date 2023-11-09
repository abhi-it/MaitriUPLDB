<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use App\Models\Avedan;
use App\Models\Districts;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('tempRecord', function () {
//     $data = \App\Models\Avedan::
//     where('is_approved', '=', 1)
//     ->
//     where('district_id', '=', 66)
//     ->whereYear('created_at', 2023)
//     ->get();
// // dd($data);
// foreach ($data as $record) {
//     $record->is_approved = 0;
//     $record->save();
// }
// });
// Route::get('test', function () {

//     $data = Avedan::select('avedans.applicationNumber', 'avedans.applicant_name', 'avedans.fname', 'avedans.mother', 'avedans.gender', 'avedans.mobile', 'avedans.email', 'avedans.high_percentage', 'avedans.inter_percentage', 'avedans.category', 'avedans.letter_address', 'districts.name_hindi as district_name')
//     ->join('districts', 'avedans.district_id', '=', 'districts.id') // Perform the join
//     ->whereYear('avedans.created_at', 2023)
//     ->orderBy('avedans.category', 'DESC')
//     ->first();

//     dd($data);

// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
