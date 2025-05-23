<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () { 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('beranda');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/edit/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/edit/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::post('/suppliers/create', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/edit/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{id}/detail', [SaleController::class, 'showDetail'])->name('sales.detail');
    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');

    // Route::get('/kasir', [CashierController::class, 'index'])->name('kasir');
    // Route::post('/kasir/add', [CashierController::class, 'addToCart'])->name('kasir.add');
    // Route::post('/kasir/remove', [CashierController::class, 'removeFromCart'])->name('kasir.remove');
    // Route::post('/kasir/checkout', [CashierController::class, 'checkout'])->name('kasir.checkout');
    // Route::get('/kasir', Kasir::class)->name('kasir');

    Route::get('/kasir', function () {
        return view('cashier.index');
    })->name('kasir');

    Route::post('/midtrans/notification', [MidtransController::class, 'notification']);
});    




Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');