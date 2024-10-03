<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvedanController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MaitriController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DemandRequestController;
use App\Http\Controllers\CVOOfficerController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ZoneStockController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UpdateController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Clear route cache
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache cleared';
});

Route::get('google-map', [GoogleController::class, 'index']);
//Clear config cache
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache cleared';
});

/*------------------------------------------------*/
Route::get('/optimize', function () {
    Artisan::call('optimize');
    dd('optimize done');
});

Route::get('/optimizeClear', function () {
    Artisan::call('optimize:clear');
    dd('Welcome');
});

Route::get('/generate', function () {
    Artisan::call('key:generate');
    dd('optimize done');
});

Route::get('/routeClear', function () {
    Artisan::call('route:clear');
    dd('Welcome');
});
/*------------------------------------------------*/

Route::get('/', function () {
    return view('home');
});

Route::get('changeLang', [LangController::class, 'change'])->name('changeLang');
// Route::get("/get-vikaskhand", function () {

//     dd("Hello");
//     return view('home');
// });

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('verifyotp/{id}', [LoginController::class, 'verifyotp'])->name('verifyotp');
Route::post('otpverification', [LoginController::class, 'otpverification'])->name('otpverification');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/yogyata', [App\Http\Controllers\HomeController::class, 'yogyata'])->name('yogyata');
Route::get('/lakshya', [App\Http\Controllers\HomeController::class, 'lakshya'])->name('lakshya');
Route::get('/yojna', [App\Http\Controllers\HomeController::class, 'yojna'])->name('yojna');
Route::get('/term-condition', [App\Http\Controllers\HomeController::class, 'termCondition'])->name('termCondition');
Route::get('/avedan-karein', [App\Http\Controllers\HomeController::class, 'avedanKarein'])->name('avedanKarein');


Route::get('/event-details', [App\Http\Controllers\HomeController::class, 'eventDetails'])->name('eventdetails');


Route::resource('application-form', AvedanController::class);
Route::post("getTempData", [AvedanController::class, 'getTempData']);

Route::get('/getAllBlocks', [AvedanController::class, 'getAllBlocks'])->name('getAllBlocks');
Route::get('/getAllGramPanchayat', [AvedanController::class, 'getAllGramPanchayat'])->name('getAllGramPanchayat');

Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])->name('index');
Route::get('/application-status', [App\Http\Controllers\HomeController::class, 'applicationStatus'])->name('applicationStatus');
Route::post('/view-application-status', [App\Http\Controllers\HomeController::class, 'viewApplicationStatus'])->name('viewApplicationStatus');
Route::get("downloadFile/{id}", [App\Http\Controllers\HomeController::class, 'downloadFile'])->name('downloadFile');

Route::get("viewCalculation/{id}", [App\Http\Controllers\HomeController::class, 'viewCalculation'])->name('viewCalculation');
Route::get("changeStatus/{id}/{join_status}", [App\Http\Controllers\HomeController::class, 'changeStatus'])->name('changeStatus');

Route::get('/downloads', [App\Http\Controllers\HomeController::class, 'downloads'])->name('downloads');

Route::get('/add-seman-form', [App\Http\Controllers\HomeController::class, 'addSemanForm'])->name('addSemanForm');
Route::post('/submitSemanForm', [App\Http\Controllers\HomeController::class, 'submitSemanForm'])->name('submitSemanForm');
Route::get('/getBlocks', [App\Http\Controllers\HomeController::class, 'getBlocks'])->name('getBlocks');

Route::group(['middleware' => ['auth', 'roles',]], function () {

    /*-------------------CVO, Director and Super Admin Start-----------------------------------------------------------------------------------*/
    Route::resource('institute', App\Http\Controllers\InstituteController::class);
    Route::get("allocation", [App\Http\Controllers\InstituteController::class, 'allocation'])->name('allocation');
    Route::get("getAvedanData", [App\Http\Controllers\InstituteController::class, 'getAvedanData'])->name('getAvedanData');
    Route::post("saveAllocation", [App\Http\Controllers\InstituteController::class, 'saveAllocation'])->name('saveAllocation');
    Route::get("allocation-list/{export?}", [App\Http\Controllers\InstituteController::class, 'allocationList'])->name('allocationList');
    Route::get("candidate-not-joined/{year?}/{export?}", [App\Http\Controllers\DashboardController::class, 'candidateNotJoined'])->name('candidateNotJoined');
    Route::get("dashboard/{year?}", [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get("avedan/{year?}/{export?}", [App\Http\Controllers\DashboardController::class, 'avedan'])->name('avedan');
    Route::get("avedan-districtwise/{year?}", [App\Http\Controllers\DashboardController::class, 'avedanDistrictwise'])->name('avedanDistrictwise');
    Route::get("get-vikaskhand", [App\Http\Controllers\DashboardController::class, 'getVikaskhand'])->name('getVikaskhand');
    Route::get("total-avedan/{year?}/{export?}", [App\Http\Controllers\DashboardController::class, 'totalAvedan'])->name('totalAvedan');
    Route::get("rejected-avedan/{year?}", [App\Http\Controllers\DashboardController::class, 'rejectedAvedan'])->name('rejectedAvedan');
    Route::get("approved-avedan/{year?}", [App\Http\Controllers\DashboardController::class, 'approvedAvedan'])->name('approvedAvedan');
    Route::get("view-Avedan-details/{id}", [App\Http\Controllers\DashboardController::class, 'avedanFullDetails'])->name('avedanFullDetails');
    Route::get("view-waiting-avedan-details/{id}", [App\Http\Controllers\DashboardController::class, 'waitingAvedanFullDetails'])->name('waitingAvedanFullDetails');
    Route::get("merit-Avedan-details/{id}", [App\Http\Controllers\DashboardController::class, 'meritAvedanDetails'])->name('meritAvedanDetails');
    Route::get("downloadFiles/{id}", [App\Http\Controllers\DashboardController::class, 'downloadFiles'])->name('downloadFiles');
    Route::get("avedanStatus/{id}/{status}", [App\Http\Controllers\DashboardController::class, 'avedanStatus'])->name('avedanStatus');
    Route::post("rejectApplication", [App\Http\Controllers\DashboardController::class, 'rejectApplication'])->name('rejectApplication');
    Route::get("all-list/{year?}", [App\Http\Controllers\DashboardController::class, 'allList'])->name('allList');
    Route::get("general-list/{year?}", [App\Http\Controllers\DashboardController::class, 'generalList'])->name('generalList');
    Route::get("obc-list/{year?}", [App\Http\Controllers\DashboardController::class, 'obcList'])->name('obcList');
    Route::get("sc-list/{year?}", [App\Http\Controllers\DashboardController::class, 'scList'])->name('scList');
    Route::get("st-list/{year?}", [App\Http\Controllers\DashboardController::class, 'stList'])->name('stList');
    Route::get("waiting-list/{id}/{export?}", [App\Http\Controllers\DashboardController::class, 'waitingList'])->name('waitingList');
    Route::get("edit-avedan/{id}", [App\Http\Controllers\DashboardController::class, 'editAvedan'])->name('editAvedan');
    Route::post("avedanUpdated/{id}", [App\Http\Controllers\DashboardController::class, 'avedanUpdated'])->name('avedanUpdated');
    Route::get("merit-list/{category}/{export?}", [App\Http\Controllers\DashboardController::class, 'meritList'])->name('meritList');
    Route::get("document-verification/{export?}", [App\Http\Controllers\DashboardController::class, 'documentVerification'])->name('documentVerification');
    Route::post("saveDocumnetVerification", [App\Http\Controllers\DashboardController::class, 'saveDocumnetVerification'])->name('saveDocumnetVerification');
    Route::resource('setting', App\Http\Controllers\SettingController::class);
    Route::get("upload-documents/{year?}/{export?}", [App\Http\Controllers\DashboardController::class, 'uploadDocuments'])->name('uploadDocuments');
    Route::get("editUploadAvedan/{id}", [App\Http\Controllers\DashboardController::class, 'editUploadAvedan'])->name('editUploadAvedan');
    Route::post("avedanUpdatedDocuments/{id}", [App\Http\Controllers\DashboardController::class, 'avedanUpdatedDocuments'])->name('avedanUpdatedDocuments');
    Route::get("upload-health-document", [App\Http\Controllers\DashboardController::class, 'uploadHealthDocument'])->name('uploadHealthDocument');
    Route::post("uploadDocuments", [App\Http\Controllers\DashboardController::class, 'uploadDocuments'])->name('uploadDocumentsPost');
    Route::get("changePassword", [App\Http\Controllers\ChangePasswordController::class, 'index'])->name('changePasswordIndex');
    Route::post("changePassword", [App\Http\Controllers\ChangePasswordController::class, 'changePassword'])->name('changePasswordPost');
    Route::get("export", [App\Http\Controllers\DashboardController::class, 'export'])->name('export');

    Route::get("export", [App\Http\Controllers\DashboardController::class, 'export'])->name('export');


    Route::resource('maitri', MaitriController::class);
    Route::get("maitri-home", [MaitriController::class, 'maitri_home'])->name('maitri-home');
    Route::get("maitri-form", [MaitriController::class, 'maitri_form'])->name('maitri-form');
    Route::get("maitri-import", [MaitriController::class, 'maitri_import'])->name('maitri-import');
    Route::get("maitri-map", [MaitriController::class, 'maitri_map'])->name('maitri-map');

    Route::post("addUpdateMaitri", [MaitriController::class, 'addUpdateMaitri'])->name('addUpdateMaitri');
    Route::post("importMaitries", [MaitriController::class, 'importMaitries'])->name('importMaitries');


    Route::get("getJanpadUnique", [MaitriController::class, 'getJanpadUnique'])->name('getJanpadUnique');
    Route::get("allMaitriesData", [MaitriController::class, 'allMaitriesData'])->name('allMaitriesData');

    Route::get("cvo-officer", [CVOOfficerController::class, 'index'])->name('cvo-officer');
    Route::get("officers-import", [CVOOfficerController::class, 'officerImportForm'])->name('officers-import');
    Route::post("importofficers", [CVOOfficerController::class, 'importOfficers'])->name('importofficers');

    Route::get("demand-requests-list", [DemandRequestController::class, 'demandRequestsListing'])->name('demand-requests-list');
    Route::post("deleteRequests", [DemandRequestController::class, 'deleteDemandRequests'])->name('deleteRequests');

    Route::get("maitri-listing", [MaitriController::class, 'maitriListing'])->name('maitri-listing');
    Route::get("getallmaitrifilterlist", [MaitriController::class, 'maitriListing'])->name('getallmaitrifilterlist');


    Route::get("getallofficers", [CVOOfficerController::class, 'getAllOfficers'])->name('getallofficers');

    Route::get("exportselectedmaitries", [MaitriController::class, 'exportMaitri'])->name('exportselectedmaitries');

    Route::get("getallAIcenters", [MaitriController::class, 'getAllAICenters'])->name('getallAIcenters');
    Route::get("getalldistrictdata", [MaitriController::class, 'getAllDistrictData'])->name('getalldistrictdata');
    Route::get("exportselectedAIcenters", [MaitriController::class, 'exportAICenters'])->name('exportselectedAIcenters');
    Route::get("exportselectedLocation", [MaitriController::class, 'exportLocations'])->name('exportselectedLocation');

    Route::get("latest-updates", [UpdateController::class, 'getAllLatestUpdated'])->name('latest-updates');
    Route::get("add-latest-update", [UpdateController::class, 'AddLatestUpdated'])->name('add-latest-update');
    Route::get("edit-latest-updated/{id}", [UpdateController::class, 'editLatestUpdated'])->name('edit-latest-updated');
    Route::post("addUpdateLatestNews", [UpdateController::class, 'addUpdateLatestNews'])->name('addUpdateLatestNews');
    Route::post("changeStatusUpdates", [UpdateController::class, 'changeStatusUpdates'])->name('changeStatusUpdates');
    Route::post("delete-updates", [UpdateController::class, 'deleteLatestUpdates'])->name('delete-updates');


    //maitri dashbaord
    Route::get("maitri-dashboard", [App\Http\Controllers\maitri\MaitriController::class, 'index'])->name('maitri-dashboard');
    Route::post("maitri-dashdata", [App\Http\Controllers\maitri\MaitriController::class, 'maitriDashbaordData'])->name('maitri-dashdata');
    Route::get("request-list", [App\Http\Controllers\maitri\MaitriController::class, 'getAllServiceRequest'])->name('request-list');
    Route::post("updateServiceRequest", [App\Http\Controllers\maitri\MaitriController::class, 'updateServiceRequest'])->name('updateServiceRequest');
    Route::get("monthly-report", [App\Http\Controllers\maitri\MaitriController::class, 'monthlyProgressReport'])->name('monthly-report');
    Route::post("filtered-monthly-report", [App\Http\Controllers\maitri\MaitriController::class, 'filteredMonthlyReport'])->name('filtered-monthly-report');


    //farmer dashbaord
    Route::get("farmer-dashboard", [App\Http\Controllers\farmer\FarmerController::class, 'index'])->name('farmer-dashboard');
    Route::get("service-request", [App\Http\Controllers\farmer\FarmerController::class, 'getServiceFrom'])->name('service-request');
    Route::post("get-all-maitri", [App\Http\Controllers\farmer\FarmerController::class, 'getAllMaitries'])->name('get-all-maitri');
    Route::post("farmer-request", [App\Http\Controllers\farmer\FarmerController::class, 'addFarmerRequests'])->name('farmer-request');
    Route::get("farmer-requests", [App\Http\Controllers\farmer\FarmerController::class, 'getAllServiceRequest'])->name('farmer-requests');
    Route::post('delete-request', [App\Http\Controllers\farmer\FarmerController::class, 'deleteRequest'])->name('delete-request');
    Route::post("farmer-dashdata", [App\Http\Controllers\farmer\FarmerController::class, 'farmerDashRequest'])->name('farmer-dashdata');

    Route::get("high-yielding-animal", [App\Http\Controllers\farmer\FarmerController::class, 'highYieldingAnimal'])->name('high-yielding-animal');
    Route::get("add-yielding-animal", [App\Http\Controllers\farmer\FarmerController::class, 'addAnimaldetailsform'])->name('add-yielding-animal');
    Route::post("addUpdateAnimalDetails", [App\Http\Controllers\farmer\FarmerController::class, 'addUpdateAnimalDetails'])->name('addUpdateAnimalDetails');

    Route::get('shapathPatraList', [App\Http\Controllers\HomeController::class, 'shapathPatraList'])->name('shapathPatraList');
    Route::get('upload-selectedcandidate', [App\Http\Controllers\HomeController::class, 'uplaodShapatpatra'])->name('upload-selectedcandidate');
    Route::post('uploadScannedFile', [App\Http\Controllers\HomeController::class, 'uploadScannedFile'])->name('uploadScannedFile');
    Route::get("totalsessionlist", [App\Http\Controllers\DashboardController::class, 'totalsessionlist'])->name('totalsessionlist');

    Route::get("getallLiveStockData", [MaitriController::class, 'getallLiveStockData'])->name('getallLiveStockData');


    // inventory
    Route::get("inventory", [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory');
    Route::get("deo-user-step1", [App\Http\Controllers\DeoUserController::class, 'create'])->name('deo-user-step1');
    Route::post("deo-user-store-step1", [App\Http\Controllers\DeoUserController::class, 'createStep1'])->name('deo-user-store-step1');
    Route::get("deo-user-step2", [App\Http\Controllers\DeoUserController::class, 'createStep2'])->name('deo-user-step2');
    Route::post("deo-user-store-step2", [App\Http\Controllers\DeoUserController::class, 'createStoreStep2'])->name('deo-user-store-step2');


    /*-------------------CVO, Director and Super Admin End-----------------------------------------------------------------------------------*/

    // google map routes
});

Route::get("farmer-register", [App\Http\Controllers\UsersController::class, 'index'])->name('farmer-register');
Route::post("farmer-add", [App\Http\Controllers\UsersController::class, 'farmerRegister'])->name('farmer-add');
Route::post("get-district", [App\Http\Controllers\UsersController::class, 'getAllDistrict'])->name('get-district');
Route::post("get-village-grampanchayat", [App\Http\Controllers\UsersController::class, 'getAllVillage'])->name('get-village-grampanchayat');
Route::post("get-block", [App\Http\Controllers\UsersController::class, 'getAllBlockById'])->name('get-block');
Route::post("get-village", [App\Http\Controllers\UsersController::class, 'getAllVillageById'])->name('get-village');


// Route::get("maitri-register", [App\Http\Controllers\UsersController::class, 'maitriform'])->name('maitri-register');
Route::post("maitri-add", [App\Http\Controllers\UsersController::class, 'maitriRegister'])->name('maitri-add');


Route::get("demandRequests", [DemandRequestController::class, 'index'])->name('demandRequests');
Route::get("getAllrequestedBlocks", [DemandRequestController::class, 'getAllrequestedBlocks'])->name('getAllrequestedBlocks');
Route::post("addDemandRequests", [DemandRequestController::class, 'addDemandRequests'])->name('addDemandRequests');
Route::get("exportDemandRequest", [DemandRequestController::class, 'exportDemandRequest'])->name('exportDemandRequest');
Route::get("view-request-details/{id}", [DemandRequestController::class, 'viewRequestDetails'])->name('view-request-details');


Route::get("exportCVOList", [CVOOfficerController::class, 'exportCVOList'])->name('exportCVOList');
Route::get("view-officer-details/{id}", [CVOOfficerController::class, 'viewOfficersDetails'])->name('view-officer-details');

// Route::post('uploadScannedFile', [App\Http\Controllers\HomeController::class, 'uploadScannedFile'])->name('uploadScannedFile');

// Route::get("refresher-training", [App\Http\Controllers\UsersController::class, 'refresherTraining'])->name('refresher-training');
Route::post("training-requests", [App\Http\Controllers\UsersController::class, 'addRefreshTraining'])->name('training-requests');

Route::get("zonestockform", [ZoneStockController::class, 'index'])->name('zonestockform');
Route::post("zonestoreadd", [ZoneStockController::class, 'zoneStoreData'])->name('zonestoreadd');


Route::get('gallery-page', [CVOOfficerController::class, 'gallery'])->name('gallery-page');

// Route::get('test', function () {

//     $data = DB::table('settings')
//     ->where('id', 2) // Assuming you want to update the record with id 2
//     ->update([
//         'start_date' => date('Y-m-d', strtotime('10-10-2023')),
//         'end_date' => date('Y-m-d', strtotime('25-10-2023')),
//     ]);


//     dd($data);
// });

Route::get('/latest-record-year', function(){
    $year = optional(\App\Models\Avedan::latest()->first())->created_at->format('Y');
dd($year);
});
