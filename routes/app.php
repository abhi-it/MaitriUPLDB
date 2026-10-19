<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\DemandRequestController;
use App\Http\Controllers\Api\MonthlyProgressReportController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\V2\AuthControllerV2;
use App\Http\Controllers\Api\V2\FarmerControllerV2;
use App\Http\Controllers\Api\V2\MaitriControllerV2;

Route::prefix('auth/v1')->group(function () {
    Route::get("get-mandal", [CommonController::class, 'getMandal']);
    Route::get("get-district", [CommonController::class, 'getDistrict']);
    Route::get("get-tehsil", [CommonController::class, 'getTehsilAll']);
    Route::get("get-block", [CommonController::class, 'getBlockAll']);
    Route::get("get-aicenter", [CommonController::class, 'getAiCenterAll']);
    Route::get("get-insitute", [CommonController::class, 'getInsitute']);
    Route::get("get-semen-data", [CommonController::class, 'getSemenData']);
    Route::get("about-us", [CommonController::class, 'getAboutUs']);
    Route::get("terms-condition", [CommonController::class, 'getTermsAndConditions']);
    Route::get('tutorials', [CommonController::class, 'tutorials'])->name('tutorials');
});

Route::group(['prefix'     => 'auth/v1/', 'middleware' => ['jwt.verify'],], function () {
    Route::get('logout',          [AuthControllerV2::class, 'logout']);
    Route::post('change-password',[AuthControllerV2::class, 'changePassword']);
    Route::get('dashboard',       [AuthControllerV2::class, 'dashboard']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);
    Route::get('get-profile-details', [ProfileController::class, 'getProfileDetails']);
});

// Farmer-only authenticated APIs
Route::group(['prefix' => 'auth/v1/farmer', 'middleware' => ['farmer.api']], function () {

    Route::get('service-request-list', [FarmerControllerV2::class, 'serviceRequestList']);
    Route::get('service-request-formdata', [FarmerControllerV2::class, 'serviceRequestFormData']);
    Route::post('service-request', [FarmerControllerV2::class, 'submitServiceRequest'])->name('api.farmer-service-request-submit');
    Route::get('get-farmer-details', [FarmerControllerV2::class, 'farmerDetails'])->name('api.get-farmer-details');
    Route::post('update-farmer-details', [FarmerControllerV2::class, 'updateFarmerDetails'])->name('api.update-farmer-details');
    
    Route::get('get-maitri-list', [FarmerControllerV2::class, 'getMaitriList'])->name('api.update-farmer-details');

    // High yielding animal
    Route::get('get-high-yielding-animal-list', [FarmerControllerV2::class, 'highYieldingAnimalList'])->name('api.high-yielding-animal');
    Route::get('get-yielding-animal', [FarmerControllerV2::class, 'getYieldingAnimalForm'])->name('api.get-yielding-animal');
    Route::post('add-update-animal-details', [FarmerControllerV2::class, 'addUpdateAnimalDetails'])->name('api.add-update-animal-details');

    Route::post('add-animal',       [FarmerControllerV2::class, 'addAnimal'])->name('api.add-animal');
    Route::get('get-all-animal',     [FarmerControllerV2::class, 'getAllAnimal'])->name('api.get-all-animal');
    Route::post('update-animal',     [FarmerControllerV2::class, 'updateAnimal'])->name('api.update-animal');
    Route::post('delete-animal',     [FarmerControllerV2::class, 'deleteAnimal'])->name('api.delete-animal');
});

// Maitri-only authenticated APIs
Route::group(['prefix' => 'auth/v1/maitri', 'middleware' => ['maitri.api']], function () {

    Route::post('dashboard-data', [MaitriControllerV2::class, 'maitriDashData'])->name('api.maitri-dashdata');
    Route::get('request-list', [MaitriControllerV2::class, 'requestList'])->name('api.maitri-request-list');
    Route::post('update-service-request', [MaitriControllerV2::class, 'updateServiceRequestStatus'])->name('api.maitri-update-service-request');
    Route::get('maitri-details', [MaitriControllerV2::class, 'maitriProfileDetails'])->name('api.maitri-details');
    Route::post('update-maitri-detail', [MaitriControllerV2::class, 'updateMaitriProfile'])->name('api.update-maitri-detail');

    Route::post('add-demand-request', [DemandRequestController::class, 'addDemandRequest']);
    Route::post('add-demand-request-latest', [DemandRequestController::class, 'addDemandRequestLatest']);
    Route::get('get-demand-request',  [DemandRequestController::class, 'getDemandRequest']);
    Route::get('monthly-progress-report', [MonthlyProgressReportController::class, 'monthlyProgressReport']);
});
