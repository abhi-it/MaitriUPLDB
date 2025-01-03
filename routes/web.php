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
use App\Http\Controllers\CreateZoneController;
use App\Http\Controllers\ZoneStockDetailsController;
use App\Http\Controllers\ZoneDashBoardController;
use App\Http\Controllers\DivisionUserController;
use App\Http\Controllers\DistrictUserController;
use App\Http\Controllers\BlockUserController;
use App\Http\Controllers\DeoStockUserController;
use App\Http\Controllers\ImportAIcenterController;
use App\Http\Controllers\ZoneDistrictController;
use App\Http\Controllers\GeoLocationUpdateController;



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
    
    Route::get("placed-candidates", [App\Http\Controllers\DashboardController::class, 'placedCandidates'])->name('placed-candidates');
    
    
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


    

    Route::get("zone-district-mapping", [ZoneDistrictController::class, 'index'])->name('zone-district-mapping');
    Route::get('/districts/{zone_id}', [ZoneDistrictController::class, 'getDistricts'])->name('getAll-District');
    Route::post('/save-selection', [ZoneDistrictController::class, 'store'])->name('save-selection');


    Route::get("getJanpadUnique", [MaitriController::class, 'getJanpadUnique'])->name('getJanpadUnique');
    Route::get("allMaitriesData", [MaitriController::class, 'allMaitriesData'])->name('allMaitriesData');

    Route::get('get-record-details', [CVOOfficerController::class, 'getRecordDetails'])->name('get-record-details');
    Route::get("cvo-officer", [CVOOfficerController::class, 'index'])->name('cvo-officer');
    Route::get("officers-import", [CVOOfficerController::class, 'officerImportForm'])->name('officers-import');
    Route::get("view-imported-data-by", [CVOOfficerController::class, 'viewImportedBy'])->name('view-imported-data-by');
    Route::post("importofficers", [CVOOfficerController::class, 'importOfficers'])->name('importofficers');
    
    Route::get("import-aicenter", [ImportAIcenterController::class, 'aicenterImportForm'])->name('import-aicenter');
    Route::post("importAiCenter", [ImportAIcenterController::class, 'importAiCenter'])->name('importAiCenter');
    

    Route::get("demand-requests-list", [DemandRequestController::class, 'demandRequestsListing'])->name('demand-requests-list');
    Route::post("deleteRequests", [DemandRequestController::class, 'deleteDemandRequests'])->name('deleteRequests');

    Route::get("maitri-listing", [MaitriController::class, 'maitriListing'])->name('maitri-listing');
    Route::get("getallmaitrifilterlist", [MaitriController::class, 'maitriListing'])->name('getallmaitrifilterlist');

    Route::get('/matri-to-fetch-record/{id}', [MaitriController::class, 'fetchRecord'])->name('matri-to-fetch-record');
    Route::post('/matri-to-update-record', [MaitriController::class, 'updateRecord'])->name('matri-to-update-record');


    Route::get("getallofficers", [CVOOfficerController::class, 'getAllOfficers'])->name('getallofficers');

    Route::get("exportselectedmaitries", [MaitriController::class, 'exportMaitri'])->name('exportselectedmaitries');

    Route::get("getallAIcenters", [MaitriController::class, 'getAllAICenters'])->name('getallAIcenters');
    Route::get("getalldistrictdata", [MaitriController::class, 'getAllDistrictData'])->name('getalldistrictdata');
    Route::get("exportselectedAIcenters", [MaitriController::class, 'exportAICenters'])->name('exportselectedAIcenters');
    Route::get("exportAllAIcenters", [MaitriController::class, 'exportAllAIcenters'])->name('exportAllAIcenters');
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


    // Update Maitri GEO Location
    Route::get("inactive-maitri-geo-location", [GeoLocationUpdateController::class, 'inactiveMaitriGEO'])->name('inactive-maitri-geo-location');
    Route::get("inactive-aicenter-geo-location", [GeoLocationUpdateController::class, 'inactiveAiCneterGEO'])->name('inactive-aicenter-geo-location');
    
    Route::get("all-maitri-geo-location", [GeoLocationUpdateController::class, 'index'])->name('all-maitri-geo-location');
    Route::get("edit-geo-maitri/{id}/edit", [GeoLocationUpdateController::class, 'editGeoLocation'])->name('edit-geo-maitri');
    Route::post("update-geo-location", [GeoLocationUpdateController::class, 'updateGeoLocation'])->name('update-geo-location');
    
    Route::get("all-aicenter-geo-location", [GeoLocationUpdateController::class, 'aicenterindex'])->name('all-aicenter-geo-location');
    Route::get("edit-geo-aicenter/{id}/edit", [GeoLocationUpdateController::class, 'editGeoAicenter'])->name('edit-geo-aicenter');
    Route::post("update-aicenter-data", [GeoLocationUpdateController::class, 'updateAicenterLocation'])->name('update-aicenter-data');

    // zone dashboard
    Route::get("change-password", [CreateZoneController::class, 'changePassword'])->name('change-password');
    
    Route::get("zone-dashboard", [ZoneDashBoardController::class, 'dashboard'])->name('zone-dashboard');
    Route::get("zone-inventory", [ZoneDashBoardController::class, 'zoneInventory'])->name('zone-inventory');
    Route::get("create-division-user", [ZoneDashBoardController::class, 'createDivisionUser'])->name('create-division-user');
    Route::get("division-user-step2", [ZoneDashBoardController::class, 'divisionUserStep2'])->name('division-user-step2');
    Route::post("division-store-data", [ZoneDashBoardController::class, 'divisionStoreData'])->name('division-store-data');
    Route::post("store-division-user-data", [ZoneDashBoardController::class, 'storeDivisionData'])->name('store-division-user-data');

    // division dashboard  
    Route::get("division-stock-details", [DivisionUserController::class, 'divisionStockRecord'])->name('division-stock-details');
    Route::get("division-inventory", [DivisionUserController::class, 'divisionInventory'])->name('division-inventory');
    Route::get("divison-show-stock-record", [DivisionUserController::class, 'divisionStockDetails'])->name('divison-show-stock-record');
    Route::get("show-division-stock-form", [DivisionUserController::class, 'divisionStockForm'])->name('show-division-stock-form');
    Route::post("division-save-stock-data", [DivisionUserController::class, 'divisionSaveStockData'])->name('division-save-stock-data');
    
    Route::get("create-disctrict-user-form", [DivisionUserController::class, 'createDistrictUser'])->name('create-disctrict-user-form');
    Route::get("division-store-data-step2", [DivisionUserController::class, 'divisionUserStep2'])->name('division-store-data-step2');
    Route::post("district-store-data", [DivisionUserController::class, 'districtStoreData'])->name('district-store-data');
    Route::post("district-user-data-store", [DivisionUserController::class, 'districtUserStoreData'])->name('district-user-data-store');

    // district dashboard 
    Route::get("ai-center-get", [DistrictUserController::class, 'aiCenterGet'])->name('ai-center-get');
    Route::get("district-request-data", [DistrictUserController::class, 'districtRequestForm'])->name('district-request-data');
    Route::get("district-show-stock-record", [DistrictUserController::class, 'districtShowRecord'])->name('district-show-stock-record');
    Route::get("district-inventory", [DistrictUserController::class, 'districtInventory'])->name('district-inventory');
    Route::get("district-stock-details", [DistrictUserController::class, 'districtStockDetails'])->name('district-stock-details');
    Route::get("show-district-stock-form", [DistrictUserController::class, 'districtStockForm'])->name('show-district-stock-form');
    Route::post("district-save-stock-data", [DistrictUserController::class, 'districtSaveStockData'])->name('district-save-stock-data');
    
    Route::get("create-block-user-form", [DistrictUserController::class, 'createBlocktUser'])->name('create-block-user-form');
    Route::get("district-store-data-step2", [DistrictUserController::class, 'districtStoreStep2'])->name('district-store-data-step2');
    Route::post("store-district-user-data", [DistrictUserController::class, 'storeDistrictData'])->name('store-district-user-data');
    Route::post("district-store-user-data", [DistrictUserController::class, 'userDataDistrictStore'])->name('district-store-user-data');

    // block dashboard  
    Route::get("block-request-data", [BlockUserController::class, 'blockRequestData'])->name('block-request-data');
    Route::get("block-request-record-data", [BlockUserController::class, 'blockRequestRecord'])->name('block-request-record-data');
    Route::post("block-request-save-form-data", [BlockUserController::class, 'blockRequestDataSave'])->name('block-request-save-form-data');
    Route::get("block-stock-details", [BlockUserController::class, 'blockStockDetails'])->name('block-stock-details');
    Route::get("show-block-stock-form", [BlockUserController::class, 'blockStockForm'])->name('show-block-stock-form');
    Route::get("block-show-stock-record", [BlockUserController::class, 'showBlockStockData'])->name('block-show-stock-record');
    Route::get("block-inventory", [BlockUserController::class, 'blockInventory'])->name('block-inventory');
    Route::get("create-deo-user-form", [BlockUserController::class, 'createDeoUser'])->name('create-deo-user-form');
    Route::get("deo-store-data-step2", [BlockUserController::class, 'deoStoreDataStep2'])->name('deo-store-data-step2');
    Route::post("block-save-stock-data", [BlockUserController::class, 'blockStockSaveData'])->name('block-save-stock-data');
    Route::post("store-deo-user-data", [BlockUserController::class, 'storeDeoUserData'])->name('store-deo-user-data');
    Route::post("deo-store-user-data", [BlockUserController::class, 'deoUserDataStore'])->name('deo-store-user-data');
    
    // deo dashboard 
    Route::get("search-maitri-data", [DeoStockUserController::class, 'searchMaitriData'])->name('search-maitri-data');
    Route::get("deo-inventory", [DeoStockUserController::class, 'deoInventory'])->name('deo-inventory');
    Route::get("deo-show-stock-record", [DeoStockUserController::class, 'deoStockRecord'])->name('deo-show-stock-record');
    Route::get("deo-stock-details", [DeoStockUserController::class, 'deoStockDetaikls'])->name('deo-stock-details');
    Route::get("deo-stock-form", [DeoStockUserController::class, 'deoStockForm'])->name('deo-stock-form');
    Route::get("deo-request-data", [DeoStockUserController::class, 'deoRequestDataForm'])->name('deo-request-data');
    Route::get("deo-request-record-data", [DeoStockUserController::class, 'deoRequestRecord'])->name('deo-request-record-data');
    Route::post("deo-save-stock-data", [DeoStockUserController::class, 'deoSaveStockData'])->name('deo-save-stock-data');
    Route::post("deo-request-save-form-data", [DeoStockUserController::class, 'deoRequestSaveData'])->name('deo-request-save-form-data');

    
    

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

    Route::post('save-events-data/{id?}', [App\Http\Controllers\AdminInventoryController::class, 'storeOrUpdate'])->name('save-events-data');

    Route::get('/events/{id}/edit', [App\Http\Controllers\AdminInventoryController::class, 'createOrEdit'])->name('edit-event');
    Route::delete('/events/{id}', [App\Http\Controllers\AdminInventoryController::class, 'destroy'])->name('events-delete');

    // Route::post('save-events-data', [App\Http\Controllers\AdminInventoryController::class, 'store'])->name('save-events-data');
    Route::get("create-event-news", [App\Http\Controllers\AdminInventoryController::class, 'createOrEdit'])->name('create-event-news');
    Route::get("event-news", [App\Http\Controllers\AdminInventoryController::class, 'eventAndNews'])->name('event-news');
    Route::get("check-zone-user", [App\Http\Controllers\AdminInventoryController::class, 'checkZoneUser'])->name('check-zone-user');
    Route::get("admin-distributed-record", [App\Http\Controllers\AdminInventoryController::class, 'adminDkistributedRecord'])->name('admin-distributed-record');
    Route::get("daily-dashboard", [App\Http\Controllers\AdminInventoryController::class, 'adminDailyDashboard'])->name('daily-dashboard');
    Route::post("save-daily-dashboard", [App\Http\Controllers\AdminInventoryController::class, 'saveDaliDashboard'])->name('save-daily-dashboard');
    Route::get("admin-stock-form", [App\Http\Controllers\AdminInventoryController::class, 'adminStockForm'])->name('admin-stock-form');
    Route::get("admin-inventory-record", [App\Http\Controllers\AdminInventoryController::class, 'adminStockRecord'])->name('admin-inventory-record');
    Route::post("admin-stock-save-data", [App\Http\Controllers\AdminInventoryController::class, 'adminStockDataSave'])->name('admin-stock-save-data');
    
    

    Route::get("farmers-data", [App\Http\Controllers\AdminInventoryController::class, 'farmarsData'])->name('farmers-data');
    Route::get("exportFarmarList", [App\Http\Controllers\AdminInventoryController::class, 'exportFarmarList'])->name('exportFarmarList');
    
    Route::get("inactive-maitri-aicenter", [App\Http\Controllers\AdminInventoryController::class, 'inactiveMaitriAicenterData'])->name('inactive-maitri-aicenter');
    Route::get("create-maitri-aicenter", [App\Http\Controllers\AdminInventoryController::class, 'createMaitriAicenter'])->name('create-maitri-aicenter');
    Route::post("create-mairti-aicenter-data", [App\Http\Controllers\AdminInventoryController::class, 'createMaitriAicenterData'])->name('create-mairti-aicenter-data');
    
    Route::get('/generate-pdf/{id}', [App\Http\Controllers\AdminInventoryController::class, 'generatePDF'])->name('generate-certificate');

    Route::get("view-update-maitri-aicenter", [App\Http\Controllers\AdminInventoryController::class, 'viewMaitriData'])->name('view-update-maitri-aicenter');
    Route::get("edit-maitri-record/{id}/edit", [App\Http\Controllers\AdminInventoryController::class, 'editMaitriAicenter'])->name('edit-maitri-record');
    Route::post("update-mairti-aicenter-data", [App\Http\Controllers\AdminInventoryController::class, 'updateMaitriData'])->name('update-mairti-aicenter-data');
    
    

    Route::get("inventory", [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory');
    Route::get("check-stock-limit", [App\Http\Controllers\InventoryController::class, 'checkStockLimit'])->name('check-stock-limit');
    Route::post("saveInentorrData", [App\Http\Controllers\InventoryController::class, 'zoneStoreData'])->name('saveInentorrData');
    
    
    Route::get("get-all-zone-aicenter", [App\Http\Controllers\DeoUserController::class, 'getAllZoneAICenter'])->name('get-all-zone-aicenter');
    Route::get("get-all-zone-district", [App\Http\Controllers\DeoUserController::class, 'getAllZoneDistrict'])->name('get-all-zone-district');
    Route::get("operator-id", [App\Http\Controllers\OperatorIdController::class, 'index'])->name('operator-id');
    Route::get("edit-user/{id}/edit", [App\Http\Controllers\OperatorIdController::class, 'editUser'])->name('edit-user');
    Route::post("update-user", [App\Http\Controllers\OperatorIdController::class, 'updateUser'])->name('update-user');
    Route::delete("user-delete/{id}", [App\Http\Controllers\OperatorIdController::class, 'userDelete'])->name('user-delete');
    
    Route::get("deo-user-step1", [App\Http\Controllers\DeoUserController::class, 'create'])->name('deo-user-step1');
    Route::get("deo-user-step2", [App\Http\Controllers\DeoUserController::class, 'createStep2'])->name('deo-user-step2');
    Route::post("deo-user-store-step1", [App\Http\Controllers\DeoUserController::class, 'createStep1'])->name('deo-user-store-step1');
    Route::post("deo-user-store-step2", [App\Http\Controllers\DeoUserController::class, 'createStoreStep2'])->name('deo-user-store-step2');
    
    // District Operator
    Route::get("district-deo-user-step1", [App\Http\Controllers\DeoUserController::class, 'districtsDeoCreate'])->name('district-deo-user-step1');
    Route::get("deo-district-user-step2", [App\Http\Controllers\DeoUserController::class, 'createDistrictStep2'])->name('deo-district-user-step2');
    Route::post("district-Operator-store-step1", [App\Http\Controllers\DeoUserController::class, 'createDisctrictStep2'])->name('district-Operator-store-step1');
    Route::post("deo-district-store-step2", [App\Http\Controllers\DeoUserController::class, 'createDistrictStoreStep2'])->name('deo-district-store-step2');


    // Create Zone

    Route::get("create-zone", [CreateZoneController::class, 'index'])->name('create-zone');
    Route::get("get-zone-district", [ZoneStockDetailsController::class, 'getZoneDistrict'])->name('get-zone-district');
    Route::get("zone-stock-details", [ZoneStockDetailsController::class, 'zoneStockDetails'])->name('zone-stock-details');
    Route::get("division-stock-form", [ZoneStockDetailsController::class, 'zoneDivisionStockForm'])->name('division-stock-form');
    Route::get("show-zone-stock-record", [ZoneStockDetailsController::class, 'zoneShowStockRecord'])->name('show-zone-stock-record');
    Route::post("save-division-stock-data", [ZoneStockDetailsController::class, 'saveZoneDivisionStockForm'])->name('save-division-stock-data');
    
    Route::post("zone-store-data", [CreateZoneController::class, 'zoneStoreData'])->name('zone-store-data');
    Route::get("zone-user-create-form", [CreateZoneController::class, 'zoneUserCreateForm'])->name('zone-user-create-form');
    Route::post("zone-user-store-data", [CreateZoneController::class, 'zoneUserCreateData'])->name('zone-user-store-data');


    Route::get("get-divisions", [App\Http\Controllers\DeoUserController::class, 'getDivisions'])->name('get-divisions');
    Route::get("get-districts", [App\Http\Controllers\DeoUserController::class, 'getDistricts'])->name('get-districts');
    Route::get("get-aicenter", [App\Http\Controllers\DeoUserController::class, 'getAicenter'])->name('get-aicenter');



    Route::get("get-blocks", [App\Http\Controllers\DeoUserController::class, 'getBlocks'])->name('get-blocks');




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

Route::get("cattle-buffalo", [App\Http\Controllers\DemandRequestController::class, 'cattleBuffalo'])->name('cattle-buffalo');
Route::get("hierarchy-chart", [App\Http\Controllers\DemandRequestController::class, 'hierarchyChart'])->name('hierarchy-chart');
Route::get("demandRequests", [DemandRequestController::class, 'index'])->name('demandRequests');
Route::get("get-all-district", [DemandRequestController::class, 'getDistrictAll'])->name('get-all-district');
Route::get("get-all-tehsil", [DemandRequestController::class, 'getTehsilAll'])->name('get-all-tehsil');
Route::get("get-all-block", [DemandRequestController::class, 'getBlockAll'])->name('get-all-block');
Route::get("get-all-aicenter", [DemandRequestController::class, 'getAiCenterAll'])->name('get-all-aicenter');


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
