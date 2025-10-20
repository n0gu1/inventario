<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MovementController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');


// Inventario
Route::resource('categories', CategoryController::class)->except(['show']);

Route::resource('products', ProductController::class)->except(['show']);

Route::get('products/{product}/kardex', [ProductController::class, 'kardex'])
    ->name('products.kardex');

Route::resource('warehouses', WarehouseController::class)
    ->except(['show']);

Route::post('products/{product}/dropzone', [ProductController::class, 'dropzone'])
    ->name('products.dropzone');

// Compras
Route::resource('customers', CustomerController::class)
    ->except(['show']);

Route::resource('purchase-orders', PurchaseOrderController::class)
    ->only(['index', 'create']);

Route::resource('purchases', PurchaseController::class)
    ->only(['index', 'create']);

Route::get('purchases/{purchase}/pdf', [PurchaseController::class, 'pdf'])
    ->name('purchases.pdf');

Route::get('purchase-orders/{purchaseOrder}/pdf', [PurchaseOrderController::class, 'pdf'])
    ->name('purchase-orders.pdf');

Route::get('quotes/{quote}/pdf', [QuoteController::class, 'pdf'])
    ->name('quotes.pdf');

Route::get('sales/{sale}/pdf', [SaleController::class, 'pdf'])
    ->name('sales.pdf');

Route::get('movements/{movement}/pdf', [MovementController::class, 'pdf'])
    ->name('movements.pdf');

Route::get('transfers/{transfer}/pdf', [TransferController::class, 'pdf'])
    ->name('transfers.pdf');

// Ventas
Route::resource('suppliers', SupplierController::class)
    ->except(['show']);

Route::resource('quotes', QuoteController::class)
    ->only(['index', 'create']);

Route::resource('sales', SaleController::class)
    ->only(['index', 'create']);

// Movimientos
Route::resource('movements', MovementController::class)
    ->only(['index', 'create']);

Route::resource('transfers', TransferController::class)
    ->only(['index', 'create']);

Route::delete('images/{image}', [ImageController::class, 'destroy'])
    ->name('images.destroy');

Route::get('reports/top-products', [ReportController::class, 'topProducts'])
    ->name('reports.top-products');

Route::get('reports/top-customers', [ReportController::class, 'topCustomers'])
    ->name('reports.top-customers');

Route::get('reports/top-products', [ReportController::class, 'topProducts'])
    ->name('reports.top-products');

Route::get('reports/low-stock', [ReportController::class, 'lowStock'])
    ->name('reports.low-stock');

Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);

