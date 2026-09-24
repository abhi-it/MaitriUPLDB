<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\DemandRequestController;
use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\MaitriController;
use App\Http\Controllers\Api\MonthlyProgressReportController;

Route::prefix('auth/v1')->group(function () {
    Route::get("get-mandal", [CommonController::class, 'getMandal']);
    Route::get("get-district", [CommonController::class, 'getDistrict']);
    Route::get("get-tehsil", [CommonController::class, 'getTehsilAll']);
    Route::get("get-block", [CommonController::class, 'getBlockAll']);
    Route::get("get-aicenter", [CommonController::class, 'getAiCenterAll']);
    Route::get("get-insitute", [CommonController::class, 'getInsitute']);
    Route::get("get-semen-data", [CommonController::class, 'getSemenData']);
});

// Farmer-only authenticated APIs (JWT + FarmerApiAuth middleware)
Route::group(['prefix' => 'auth/v1/farmer', 'middleware' => ['farmer.api']], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.farmer-logout');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('api.change-password');

    Route::get('dashboard', [FarmerController::class, 'dashboard'])->name('api.farmer-dashboard');
    Route::get('service-request-list', [FarmerController::class, 'serviceRequestList']);
    Route::get('service-request-formdata', [FarmerController::class, 'serviceRequestFormData']);
    Route::post('service-request', [FarmerController::class, 'submitServiceRequest'])->name('api.farmer-service-request-submit');
    Route::get('farmer-details', [FarmerController::class, 'farmerDetails'])->name('api.farmer-details');
    Route::post('update-farmer-details', [FarmerController::class, 'updateFarmerDetails'])->name('api.update-farmer-details');
    
    Route::get('get-maitri-list', [FarmerController::class, 'getMaitriList'])->name('api.update-farmer-details');

    // High yielding animal (matches web high-yielding-animal / add-yielding-animal)
    Route::get('get-high-yielding-animal-list', [FarmerController::class, 'highYieldingAnimalList'])->name('api.high-yielding-animal');
    Route::get('get-yielding-animal', [FarmerController::class, 'getYieldingAnimalForm'])->name('api.get-yielding-animal');
    Route::post('add-update-animal-details', [FarmerController::class, 'addUpdateAnimalDetails'])->name('api.add-update-animal-details');
});

// Maitri-only authenticated APIs (JWT + MaitriApiAuth middleware)
Route::group(['prefix' => 'auth/v1/maitri', 'middleware' => ['maitri.api']], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('api.maitri-logout');

    Route::get('dashboard', [MaitriController::class, 'dashboard'])->name('api.maitri-dashboard');
    Route::post('dashboard-data', [MaitriController::class, 'maitriDashData'])->name('api.maitri-dashdata');

    Route::get('request-list', [MaitriController::class, 'requestList'])->name('api.maitri-request-list');
    Route::post('update-service-request', [MaitriController::class, 'updateServiceRequestStatus'])->name('api.maitri-update-service-request');

    Route::post('add-demand-request', [DemandRequestController::class, 'addDemandRequest']);
    Route::get('get-demand-request',  [DemandRequestController::class, 'getDemandRequest']);

    Route::get('monthly-progress-report', [MonthlyProgressReportController::class, 'monthlyProgressReport']);

    Route::get('maitri-details', [MaitriController::class, 'maitriProfileDetails'])->name('api.maitri-details');
    Route::post('update-maitri-detail', [MaitriController::class, 'updateMaitriProfile'])->name('api.update-maitri-detail');
    
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('api.change-password');
});
