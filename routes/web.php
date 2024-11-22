<?php


use App\Http\Controllers\Shopkeeper\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Shopkeeper\ShopkeeperController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('shopkeeper.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aboutme', function () {
    return view('shopkeeper.aboutme');
})->middleware(['auth', 'verified'])->name('aboutme');

//appointments
Route::get('/appointments', [ShopkeeperController::class, 'showAppointments'])->name('appointments');



//Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/service', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/service', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/service/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/service/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/service/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});

// Customer Routes
Route::group(['prefix' => 'customer','as' => 'customer.'], function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/register', [CustomerController::class, 'register_view'])->name('register.view');
    Route::post('/register', [CustomerController::class, 'register'])->name('register');
    Route::get('/login', [CustomerController::class, 'login_view'])->name('login.view');
    Route::post('/login', [CustomerController::class, 'login'])->name('login');
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

    //services
    Route::get('/services', [CustomerController::class, 'showServices'])->name('services');


    //appointments
    Route::get('/service/{service}/book', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/service/{service}/book', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointments', [CustomerController::class, 'showAppointments'])->name('appointments.index');




});



// Customer
// Route::middleware(['auth', 'role:customer'])->group(function () {
//     Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');
// });
//  Super Admin
// Route::middleware(['auth', 'role:super_admin'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.super_admin');

// });
require __DIR__.'/auth.php';
