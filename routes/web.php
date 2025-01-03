<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CryptoGatewayController;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ExternalPurchaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MobileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'role:Admin']);

    Route::get('warehouses/{warehouse}/products', [WarehouseController::class, 'getProducts']);

    Route::resource('suppliers', SupplierController::class)->middleware(['auth', 'permission:manage suppliers']);

    Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::resource('customers', CustomerController::class)->middleware(['auth', 'permission:manage customers']);

    Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
    Route::resource('brands', BrandController::class)->middleware(['auth', 'permission:manage brands']);

    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::resource('categories', CategoryController::class)->middleware(['auth', 'permission:manage categories']);

    Route::get('/products/generate-barcode', [ProductController::class, 'generateBarcode'])->name('products.generateBarcode');

    Route::resource('products', ProductController::class)->middleware(['auth', 'permission:manage products']);

    Route::resource('mobiles', MobileController::class)->middleware(['auth', 'permission:manage mobiles']);

    Route::get('/products-by-category/{categoryId}', [PurchaseController::class, 'getProductsByCategory']);

    Route::get('/purchases/history', [PurchaseController::class, 'history'])->name('purchases.history')->middleware(['auth', 'permission:manage purchases']);
    Route::resource('purchases', PurchaseController::class)->middleware(['auth', 'permission:manage purchases']);

    Route::resource('external_purchases', ExternalPurchaseController::class)->middleware(['auth', 'permission:manage external_purchases']);

    Route::get('/sales/history', [SaleController::class, 'history'])->name('sales.history')->middleware(['auth', 'permission:manage sales']);
    Route::resource('sales', SaleController::class)->middleware(['auth', 'permission:manage sales']);

    Route::resource('transactions', TransactionController::class)->middleware(['auth', 'permission:manage accounts']);

    Route::resource('users', UserController::class)->middleware(['auth', 'permission:manage users']);

    Route::get('/maintenances/{id}/print', [MaintenanceController::class, 'print'])->name('maintenances.print');
    Route::resource('maintenances', MaintenanceController::class)->middleware(['auth', 'permission:manage maintenances']);

    Route::resource('settings', SettingsController::class)->except(['show'])->middleware(['auth', 'permission:manage settings']);

    Route::resource('crypto_gateways', CryptoGatewayController::class)->middleware(['auth', 'permission:manage crypto_gateways']);

    Route::resource('warehouses', WarehouseController::class)->middleware('permission:manage warehouses');

    Route::get('crypto_transactions', [CryptoTransactionController::class, 'index'])->name('crypto_transactions.index')
        ->middleware(['auth', 'permission:manage crypto_transactions']);
    Route::get('crypto_transactions/{gatewayId}/transactions/create', [CryptoTransactionController::class, 'create'])->name('crypto_transactions.create')
        ->middleware(['auth', 'permission:manage crypto_transactions']);
    Route::post('crypto_transactions/{gatewayId}/transactions', [CryptoTransactionController::class, 'store'])->name('crypto_transactions.store')
        ->middleware(['auth', 'permission:manage crypto_transactions']);
    Route::get('crypto_transactions/history', [CryptoTransactionController::class, 'history'])->name('crypto_transactions.history')
        ->middleware(['auth', 'permission:manage crypto_transactions']);

    Route::resource('devices', DeviceController::class)->middleware(['auth', 'permission:manage devices']);
});
