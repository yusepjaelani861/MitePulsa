<?php

use App\Http\Controllers\DigiflazzController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::prefix('digiflazz')->group(function () {
        Route::get('/cek-saldo', [DigiflazzController::class, 'cek_saldo']);
        Route::get('/price-list', [DigiflazzController::class, 'daftar_harga']);
        Route::get('/cek-tagihan', [DigiflazzController::class, 'cek_tagihan']);
        Route::get('/inquiry-pln', [DigiflazzController::class, 'inquiry_pln']);

        Route::post('/topup', [DigiflazzController::class, 'topup']);
        Route::post('/bayar-tagihan', [DigiflazzController::class, 'bayar_tagihan']);
        Route::post('/webhook', [DigiflazzController::class, 'webhook']);
    });
});
