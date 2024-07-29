<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShareMarketNiftyController;
use App\Http\Controllers\Api\StokListController;
use App\Http\Controllers\Api\AngelOneController;
use App\Http\Controllers\Api\ExcelController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//nifty
Route::get('niftyStoreUpdate',[ShareMarketNiftyController::class,'niftyStoreUpdate']);
Route::get('getNifty',[ShareMarketNiftyController::class,'getNifty']);
Route::get('niftyJsonUpdate',[ShareMarketNiftyController::class,'niftyJsonUpdate']);
Route::get('getNiftyJson',[ShareMarketNiftyController::class,'getNiftyJson']);


//bankNifty
Route::get('bankNiftyStoreUpdate',[ShareMarketNiftyController::class,'bankNiftyStoreUpdate']);
Route::get('getBankNifty',[ShareMarketNiftyController::class,'getBankNifty']);
Route::get('bankNiftyJsonUpdate',[ShareMarketNiftyController::class,'bankNiftyJsonUpdate']);
Route::get('getBankNiftyJson',[ShareMarketNiftyController::class,'getBankNiftyJson']);

//stokList
Route::get('stokListUpdate',[StokListController::class,'stokListUpdate']);
Route::get('getStokList',[StokListController::class,'getStokList']);
Route::get('StokDetailUpdate',[StokListController::class,'StokDetailUpdate']);
Route::get('getStokDetail',[StokListController::class,'getStokDetail']);

//angel-one
Route::get('/place-order', [AngelOneController::class, 'placeOrder']);

//excelSheet
Route::get('dayHoraGrahWiseData',[ExcelController::class,'dayHoraGrahWiseData']);
Route::get('nightHoraGrahWiseData',[ExcelController::class,'nightHoraGrahWiseData']);
Route::get('importantgrah',[ExcelController::class,'importantGrah']);
Route::get('extractDataIntraday',[ExcelController::class,'extractDataIntraday']);
Route::post('currentDateGrah',[ExcelController::class,'currentDateGrah']);
Route::get('bhadraData',[ExcelController::class,'bhadraData']);
Route::get('importantValue',[ExcelController::class,'importantValue']);
Route::get('degree',[ExcelController::class,'degree']);
Route::post('gan-stock-price',[ExcelController::class,'ganStockPrice'])->name('gan-stock-price');
Route::post('highest-close', [ExcelController::class, 'getHighestClose']);
Route::get('getTrayodashi', [ExcelController::class, 'getTrayodashi']);
Route::get('getAmavashya', [ExcelController::class, 'getAmavashya']);

