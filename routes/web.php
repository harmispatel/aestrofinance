<?php

use App\Http\Controllers\Admin\{DashboardController,RoleController,AuthController,UserController,ForgotPasswordController};
use App\Http\Controllers\AmavasyaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IntradayController;
use App\Http\Controllers\GrahController;
use App\Http\Controllers\GrahWiseDataController;
use App\Http\Controllers\CurrentWeekStockController;
use App\Http\Controllers\NightGrahWiseDataController;
use App\Http\Controllers\ImportantGrahController;
use App\Http\Controllers\TrayodashiController;
use App\Http\Controllers\GannSolarDatesController;
use App\Http\Controllers\BhadraDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
// Cache Clear Route
Route::get('config-clear', function ()
{
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    return redirect()->route('dashboard');
});

// Frontend
Route::get('/', function ()
{
    // return view('frontend.welcome');
    return redirect()->route('admin.login');

});

// ADMIN ROUTES
// Auth::routes();
Route::group(['prefix' => 'admin'], function()
{
    Route::get('/', function ()
    {
        return redirect()->route('admin.login');
    });

    // Admin Auth Routes
    Route::get('/login', [AuthController::class,'showAdminLogin'])->name('admin.login');
    Route::post('/do/login', [AuthController::class,'Adminlogin'])->name('admin.do.login');
    Route::get('/forget-password', [ForgotPasswordController::class, 'showforgetpasswordform'])->name('forget.password.get');
    Route::post('/forget-password', [ForgotPasswordController::class, 'submitforgetpasswordform'])->name('forget.password.post');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showresetpasswordform'])->name('reset.password.get');
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitresetpasswordform'])->name('reset.password.post');


    Route::group(['middleware' => 'is_admin'], function ()
    {
        // Dashboard
        Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
        Route::post('importantValue',[DashboardController::class,'importantValue'])->name('importantValue');
        Route::get('current-nifty-price',[DashboardController::class,'currentNifty'])->name('currentNifty');
        Route::post('current-nifty-stock-wise',[DashboardController::class,'currentNiftyStockWise'])->name('currentNiftyStockWise');
        Route::post('current-nifty-save',[DashboardController::class,'currentsavedata'])->name('currentsavedata');

        //trayodashi
        Route::get('trayodashi-create',[TrayodashiController::class,'create'])->name('trayodashi.create');
        Route::post('trayodashi-store',[TrayodashiController::class,'store'])->name('trayodashi.store');
        Route::get('trayodashi-index',[TrayodashiController::class,'index'])->name('trayodashi.index');
        Route::get('trayodashi-edit/{id}',[TrayodashiController::class,'edit'])->name('trayodashi.edit');
        Route::post('trayodashi-update',[TrayodashiController::class,'update'])->name('trayodashi.update');
        Route::post('trayodashi-destroy',[TrayodashiController::class,'delete'])->name('trayodashi.destroy');

        Route::get('cuurent-week-stocks',[CurrentWeekStockController::class,'index'])->name('currentweekstock');

        //amavasya
        Route::get('amavasya-create',[AmavasyaController::class,'create'])->name('amavasya.create');
        Route::post('amavasya-store',[AmavasyaController::class,'store'])->name('amavasya.store');
        Route::get('amavasya-index',[AmavasyaController::class,'index'])->name('amavasya.index');
        Route::get('amavasya-edit/{id}',[AmavasyaController::class,'edit'])->name('amavasya.edit');
        Route::post('amavasya-update',[AmavasyaController::class,'update'])->name('amavasya.update');
        Route::post('amavasya-destroy',[AmavasyaController::class,'delete'])->name('amavasya.destroy');

        // Roles
        Route::get('roles',[RoleController::class,'index'])->name('roles');
        Route::get('roles/create',[RoleController::class,'create'])->name('roles.create');
        Route::post('roles/store',[RoleController::class,'store'])->name('roles.store');
        Route::get('roles/edit/{id}',[RoleController::class,'edit'])->name('roles.edit');
        Route::post('roles/update',[RoleController::class,'update'])->name('roles.update');
        Route::post('roles/destroy',[RoleController::class,'destroy'])->name('roles.destroy');


        // User
        Route::get('users',[UserController::class,'index'])->name('users');
        Route::get('users/create',[UserController::class,'create'])->name('users.create');
        Route::post('users/store',[UserController::class,'store'])->name('users.store');
        Route::post('users/status',[UserController::class,'status'])->name('users.status');
        Route::post('users/update',[UserController::class,'update'])->name('users.update');
        Route::get('users/edit/{id}',[UserController::class,'edit'])->name('users.edit');
        Route::post('users/destroy',[UserController::class,'destroy'])->name('users.destroy');
        Route::get('profile/edit/{id}',[UserController::class,'profileEdit'])->name('profile.edit');
        Route::post('profile/update',[UserController::class,'profileUpdate'])->name('profile.update');

        //setting
        Route::get('users/settingDetail',[UserController::class,'settingDetail'])->name('settingDetail');
        Route::get('user/settingEdit/{id}',[UserController::class,'settingEdit'])->name('settingEdit');
        Route::post('user/settingUpdate',[UserController::class,'settingUpdate'])->name('setting.update');

        // Logout Admin
        Route::get('/logout',[DashboardController::class,'adminLogout'])->name('admin.logout');

        //intraday

        Route::get("/intraday",[IntradayController::class,'index'])->name('intraday');
        Route::get("/intraday/create",[IntradayController::class,'create'])->name('intraday.create');
        Route::post("/intraday/store",[IntradayController::class,'store'])->name('intraday.store');
        Route::get("/intraday/edit/{id}",[IntradayController::class,'edit'])->name('intraday.edit');
        Route::post("/intraday/update",[IntradayController::class,'update'])->name('intraday.update');
        Route::post("/intraday/destroy",[IntradayController::class,'delete'])->name('intraday.destroy');
        Route::get("/intraday/view/{id}",[IntradayController::class,'intraView'])->name('intraday.intraView');


        //Grah
        Route::resource('grahs', GrahController::class);
        Route::post("/grah/destroy",[GrahController::class,'delete'])->name('grah.destroy');
        Route::post("/grah/update",[GrahController::class,'update'])->name('grah.update');

        //day GrahWiseData
        Route::resource('grahsdata', GrahWiseDataController::class);
        Route::post("/grahsdata/destroy",[GrahWiseDataController::class,'delete'])->name('grahdata.destroy');
        Route::post("/grahsdata/update",[GrahWiseDataController::class,'update'])->name('grahdata.update');

       // Night GrahWiseData
       Route::resource('nightgrahsdata', NightGrahWiseDataController::class);
       Route::post("/nightgrahsdata/destroy",[NightGrahWiseDataController::class,'delete'])->name('nightgrahdata.destroy');
       Route::post("/nightgrahsdata/update",[NightGrahWiseDataController::class,'update'])->name('nightgrahdata.update');

        //importantGrah
        Route::get("/ImportantGrah/view",[ImportantGrahController::class,'ImportantGrah'])->name('importantGrah.index');
        Route::post("/ImportantGrah/destroy",[ImportantGrahController::class,'delete'])->name('importantGrah.destroy');

    //Gann stocks
    Route::get('/gannstokes/solar-dates', [GannSolarDatesController::class, 'index'])->name('gannStokes.index');
    Route::get('/gannstokes/current-Stock-View/{id}', [GannSolarDatesController::class, 'currentStockView'])->name('gannStokes.currentstock');
    Route::get('/gannstokes/create', [GannSolarDatesController::class, 'create'])->name('gannStokes.create');
    Route::post('/gannstokes/calculate', [GannSolarDatesController::class, 'calculate'])->name('gannStokes.calculate');
    Route::post("/gannstokes/store",[GannSolarDatesController::class,'store'])->name('gannStocks.store');
    Route::get('/gannstokes/view/{id}', [GannSolarDatesController::class, 'view'])->name('gannStokes.view');
    Route::get('/gannstokes/edit/{id}', [GannSolarDatesController::class, 'edit'])->name('gannStokes.edit');
    Route::post('/gannstokes/update', [GannSolarDatesController::class, 'update'])->name('gannStocks.update');
    Route::post("/gannstokes/delete",[GannSolarDatesController::class,'delete'])->name('gannStocks.delete');
    Route::get('before-1-month/gannstokes/index',[GannSolarDatesController::class, 'beforemonthmonth'])->name('gannStokes.beforemotnh');
    Route::get('/fetch-stock-price', [GannSolarDatesController::class, 'getStockPrices'])->name('fetchStockPrice');


    //Bhadra data
    Route::get('/bhadraData',[BhadraDataController::class,'grahDataView'])->name('bhadra.index');
    Route::post('/bhadraData/delete',[BhadraDataController::class,'delete'])->name('bhadra.delete');
    });
});
