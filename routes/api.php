<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\MaitriController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\IVSBroadCastController;
use App\Http\Controllers\Api\LatencyController;

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
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('otp-verify', [AuthController::class, 'otpVerify'])->name('otp-verify');

    //Registration
    Route::get('getAllBlock', [RegistrationController::class, 'getAllBlock'])->name('getAllBlock');
    Route::get('mandal_list', [RegistrationController::class, 'mandal_list'])->name('mandal_list');
    Route::get('district_list', [RegistrationController::class, 'district_list'])->name('district_list');
    Route::get('tehsil_list', [RegistrationController::class, 'tehsil_list'])->name('tehsil_list');
    Route::get('animal_types', [RegistrationController::class, 'animal_types'])->name('animal_types');
    Route::post('register', [RegistrationController::class, 'register'])->name('register');
});

Route::group(['prefix' => 'auth/v1', 'middleware' => ['auth:api,farmer_api'] ], function() {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('getProfile',  [FarmerController::class, 'getProfile']);
    Route::get('view-service-request', [FarmerController::class, 'getServiceRequest'])->name('view-service-request');
    Route::post('service-request', [FarmerController::class, 'getServiceFrom'])->name('service-request');
    Route::get('maitri-list',  [FarmerController::class, 'maitri_list']);
    Route::get('service-list',  [FarmerController::class, 'serviceList']);
    Route::post('feedback',  [FarmerController::class, 'feedback']);
    Route::get('high-Yielding-Animal', [FarmerController::class, 'highYieldingAnimal']);
    Route::get('animal_list', [FarmerController::class, 'animal_list']);
    Route::post('add_animal', [FarmerController::class, 'add_animal']);
    Route::post('delete-animal', [FarmerController::class, 'delete_animal']);
    Route::post('upload-image', [FarmerController::class, 'uploadImage']);
    Route::post('update-profile', [FarmerController::class, 'update_profile']);
    
    Route::post('save-animal-info', [FarmerController::class, 'saveAnimalInfo']);
    Route::post('delete-animal-info', [FarmerController::class, 'deleteAnimalInfo']);
    Route::get('all-animal-info', [FarmerController::class, 'allAnimalInfo']);
    

    //Maitri
    Route::get('maitri/get-maitri-details', [MaitriController::class, 'getMaitriDetails']);
    Route::post('maitri/update-maitri-details', [MaitriController::class, 'updateMaitriDetails']);

    Route::get('maitri/service-categories', [MaitriController::class, 'service_category_list']);
    Route::post('monthly-progress-report', [MaitriController::class, 'monthly_progress_report']);
    Route::post('maitri/service_request', [MaitriController::class, 'service_request']);
    Route::post('maitri/update-status', [MaitriController::class, 'update_service_status']);
    Route::post('maitri/add-animal-service', [MaitriController::class, 'add_animal_service_request']);

    //Status  
    Route::get('get-status', [FarmerController::class, 'getStatus']);
    
});

Route::get('show-stages', [IVSBroadCastController::class, 'showStages'])->name('showStages');
Route::get('/ivs-stage/participants', [IVSBroadCastController::class, 'showParticipantCount']);
Route::get('/ivs-publisher', [IVSBroadCastController::class, 'generatePublisherToken']);
Route::get('/ivs-subscribers', [IVSBroadCastController::class, 'generateSubscriberToken']);


Route::get('/ivs-getPublishersList', [IVSBroadCastController::class, 'getPublishersList']);


//IVS LATENCY
Route::get('/ivs-streamInfo', [LatencyController::class, 'streamData']);



