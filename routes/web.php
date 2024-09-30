<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:Admin']], function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware(['auth', 'role:Admin']);

    Route::resource('suppliers', SupplierController::class)->middleware(['auth', 'permission:manage suppliers']);
});

Route::group(['middleware' => ['role:Salesperson']], function () {
    // مسارات البائع
    Route::get('/sales/dashboard', [App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('sales.dashboard');
    // المزيد من المسارات
});

Route::group(['middleware' => ['role:Technician']], function () {
    // مسارات الفني
    Route::get('/technician/dashboard', [App\Http\Controllers\Technician\DashboardController::class, 'index'])->name('technician.dashboard');
    // المزيد من المسارات
});
