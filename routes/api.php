<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

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
//     $data = \App\Models\Avedan::where('is_approved', '!=', 0)
//     ->whereYear('created_at', 2023)
//     ->get();
// // dd($data);
// foreach ($data as $record) {
//     $record->is_approved = 0;
//     $record->save();
// }
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
