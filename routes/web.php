<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    
    Route::get('/balances', [AdminController::class, 'balances'])->name('admin.balances');
});

require __DIR__.'/digiflazz.php';
require __DIR__.'/auth.php';
