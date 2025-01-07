<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\MaitriController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Farmer
Route::prefix('v1')->group(function () {
    Route::post('farmer-login', [AuthController::class, 'farmerLogin'])->name('farmer-login');
    Route::post('otp-verify', [AuthController::class, 'otpVerify'])->name('otp-verify');
});

Route::group(['prefix' => 'auth/v1', 'middleware' => ['auth:api'] ], function() {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('view-service-request', [FarmerController::class, 'getServiceRequest'])->name('view-service-request');
    Route::post('service-request', [FarmerController::class, 'getServiceFrom'])->name('service-request');
    Route::get('maitri-list',  [FarmerController::class, 'maitri_list']);
    Route::get('service-list',  [FarmerController::class, 'serviceList']);
    Route::post('feedback',  [FarmerController::class, 'feedback']);
    Route::get('high-Yielding-Animal', [FarmerController::class, 'highYieldingAnimal']);
    Route::get('animal_list', [FarmerController::class, 'animal_list']);
    Route::post('add_animal', [FarmerController::class, 'add_animal']);
    Route::post('delete-animal', [FarmerController::class, 'delete_animal']);
    Route::post('/upload-image', [FarmerController::class, 'uploadImage']);

    //Maitri
    Route::post('monthly-progress-report', [MaitriController::class, 'monthly_progress_report']);
    Route::post('maitri/service_request', [MaitriController::class, 'service_request']);
    Route::post('maitri/update-status', [MaitriController::class, 'update_service_status']);
    Route::get('maitri/service-categories', [MaitriController::class, 'service_category_list']);
    Route::post('maitri/add-animal-service', [MaitriController::class, 'add_animal_service_request']);
    
});