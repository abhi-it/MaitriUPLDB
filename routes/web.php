<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvedanController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

// Route::get("/get-vikaskhand", function () {

//     dd("Hello");
//     return view('home');
// });

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\HomeController::class, 'aboutUs'])->name('aboutUs');
Route::get('/yogyata', [App\Http\Controllers\HomeController::class, 'yogyata'])->name('yogyata');
Route::get('/lakshya', [App\Http\Controllers\HomeController::class, 'lakshya'])->name('lakshya');
Route::get('/yojna', [App\Http\Controllers\HomeController::class, 'yojna'])->name('yojna');
Route::get('/term-condition', [App\Http\Controllers\HomeController::class, 'termCondition'])->name('termCondition');
Route::get('/avedan-karein', [App\Http\Controllers\HomeController::class, 'avedanKarein'])->name('avedanKarein');
Route::resource('application-form', AvedanController::class);
Route::post("getTempData", [AvedanController::class, 'getTempData']);
Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])->name('index');
Route::get('/application-status', [App\Http\Controllers\HomeController::class, 'applicationStatus'])->name('applicationStatus');
Route::post('/view-application-status', [App\Http\Controllers\HomeController::class, 'viewApplicationStatus'])->name('viewApplicationStatus');
Route::get("downloadFile/{id}", [App\Http\Controllers\HomeController::class, 'downloadFile'])->name('downloadFile');

Route::get("viewCalculation/{id}", [App\Http\Controllers\HomeController::class, 'viewCalculation'])->name('viewCalculation');
Route::get("changeStatus/{id}/{join_status}", [App\Http\Controllers\HomeController::class, 'changeStatus'])->name('changeStatus');

Route::get('/downloads', [App\Http\Controllers\HomeController::class, 'downloads'])->name('downloads');

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
    /*-------------------CVO, Director and Super Admin End-----------------------------------------------------------------------------------*/

    // google map routes
});


// Route::get('test', function () {

//     $data = DB::table('settings')
//     ->where('id', 2) // Assuming you want to update the record with id 2
//     ->update([
//         'start_date' => date('Y-m-d', strtotime('10-10-2023')),
//         'end_date' => date('Y-m-d', strtotime('25-10-2023')),
//     ]);


//     dd($data);
// });
