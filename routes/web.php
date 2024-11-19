<?php


use App\Http\Controllers\Shopkeeper\ServiceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Shopkeeper Signup
Route::get('/signup/shopkeeper', [RegisteredUserController::class, 'createShopkeeper'])->name('shopkeeper.signup');
Route::post('/signup/shopkeeper', [RegisteredUserController::class, 'storeShopkeeper'])->name('shopkeeper.store');
Route::middleware(['auth', 'role:shopkeeper'])->group(function () {
    // Dashboard route
     Route::get('/dashboard', [DashboardController::class, 'shopkeeper'])->name('dashboard.shopkeeper');

    // Service  routes
    Route::prefix('/services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index'); // List all services
        Route::get('/create', [ServiceController::class, 'create'])->name('create'); // Show create form
        Route::post('/', [ServiceController::class, 'store'])->name('store'); // Store new service
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit'); // Show edit form
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update'); // Update service
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy'); // Delete service
    });
});

// Customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
});
//  Super Admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.super_admin');

});
require __DIR__.'/auth.php';
