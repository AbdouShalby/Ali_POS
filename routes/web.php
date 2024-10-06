<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CryptoGatewayController;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')
        ->middleware(['auth', 'role:Admin']);

    Route::resource('suppliers', SupplierController::class)->middleware(['auth', 'permission:manage suppliers']);

    Route::resource('customers', CustomerController::class)->middleware(['auth', 'permission:manage customers']);

    Route::resource('brands', BrandController::class)->middleware(['auth', 'permission:manage brands']);

    Route::resource('categories', CategoryController::class)->middleware(['auth', 'permission:manage categories']);

    Route::resource('products', ProductController::class)->middleware(['auth', 'permission:manage products']);

    Route::resource('mobiles', MobileController::class)->middleware(['auth', 'permission:manage mobiles']);

    Route::resource('purchases', PurchaseController::class)->middleware(['auth', 'permission:manage purchases']);

    Route::resource('sales', SaleController::class)->middleware(['auth', 'permission:manage sales']);

    Route::resource('transactions', TransactionController::class)->middleware(['auth', 'permission:manage accounts']);

    Route::resource('units', UnitController::class)->middleware(['auth', 'permission:manage units']);

    Route::resource('users', UserController::class)->middleware(['auth', 'permission:manage users']);

    Route::resource('settings', SettingsController::class)->except(['show'])->middleware(['auth', 'permission:manage settings']);

    Route::resource('crypto_gateways', CryptoGatewayController::class)->middleware(['auth', 'permission:manage crypto_gateways']);

    Route::get('crypto_transactions', [CryptoTransactionController::class, 'index'])->name('crypto_transactions.index')
        ->middleware(['auth', 'permission:manage crypto_transactions']);
    Route::get('crypto_transactions/{gatewayId}/transactions/create', [CryptoTransactionController::class, 'create'])->name('crypto_transactions.create')
        ->middleware(['auth', 'permission:manage crypto_transactions']);
    Route::post('crypto_transactions/{gatewayId}/transactions', [CryptoTransactionController::class, 'store'])->name('crypto_transactions.store')
        ->middleware(['auth', 'permission:manage crypto_transactions']);

    Route::resource('maintenances', MaintenanceController::class)->except(['show', 'edit', 'destroy'])
        ->middleware(['auth', 'permission:manage maintenances']);

    Route::resource('devices', DeviceController::class)->middleware(['auth', 'permission:manage devices']);
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
