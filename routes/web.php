<?php


use App\Http\Controllers\Shopkeeper\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Shopkeeper\ShopkeeperController;
use App\Http\Controllers\Shopkeeper\ServiceProviderController;
use App\Http\Controllers\BookingsController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

//////////////////////////////////shopkeeper routes////////////////////////////////////////
//dashboard
Route::get('/', function () {
    return view('shopkeeper.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//about me
Route::get('/aboutme', function () {
    return view('shopkeeper.aboutme');
})->middleware(['auth', 'verified'])->name('aboutme');

//appointments
Route::get('/appointments', [ShopkeeperController::class, 'showAppointments'])->name('appointments');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //schedule
    Route::get('/profile/schedule', [ProfileController::class, 'editSchedule'])->name('profile.schedule.edit'); // Edit Schedule
    Route::patch('/profile/schedule', [ProfileController::class, 'updateSchedule'])->name('profile.schedule.update');

        //services
    Route::get('/service', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/service', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/service/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/service/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/service/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    //service provider
    // Service Providers
    Route::get('/service-providers', [ServiceProviderController::class, 'index'])->name('service-providers.index');
    Route::get('/service-providers/create', [ServiceProviderController::class, 'create'])->name('service-providers.create');
    Route::post('/service-providers', [ServiceProviderController::class, 'store'])->name('service-providers.store');
    Route::get('/service-providers/{serviceProvider}/edit', [ServiceProviderController::class, 'edit'])->name('service-providers.edit');
    Route::put('/service-providers/{serviceProvider}', [ServiceProviderController::class, 'update'])->name('service-providers.update');
    Route::delete('/service-providers/{serviceProvider}', [ServiceProviderController::class, 'destroy'])->name('service-providers.destroy');
});



// ////////////////////////////Customer Routes////////////////////////
Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    // Public Routes (Accessible without authentication)
    Route::get('/register', [CustomerController::class, 'register_view'])->name('register.view');
    Route::post('/register', [CustomerController::class, 'register'])->name('register');
    Route::get('/login', [CustomerController::class, 'login_view'])->name('login.view');
    Route::post('/login', [CustomerController::class, 'login'])->name('login');

    // Protected Routes (Only accessible to logged-in customers)
    Route::middleware(['auth:customer'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

        // Appointments
        Route::get('/appointments', [CustomerController::class, 'showAppointments'])->name('appointments.index');

        // Services
        Route::get('/service/{service}/book', [AppointmentController::class, 'create'])->name('appointment.create');
        Route::post('/service/{service}/book', [AppointmentController::class, 'store'])->name('appointment.store');

        // Logout
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

        //profile
        Route::get('/', [CustomerController::class, 'index'])->name('profile.index');
        Route::get('/edit', [CustomerController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [CustomerController::class, 'update'])->name('profile.update');
        Route::get('/password', [CustomerController::class, 'editPassword'])->name('profile.password.edit');
        Route::patch('/password/update', [CustomerController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/delete', [CustomerController::class, 'destroy'])->name('profile.delete');
 });


    // Services (Public)
    Route::get('/services', [CustomerController::class, 'showServices'])->name('services');
});

Route::middleware(['auth:customer'])->prefix('customer/profile')->name('customer.profile.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('profile.index');
    Route::get('/edit', [CustomerController::class, 'edit'])->name('profile.edit');
    Route::patch('/update', [CustomerController::class, 'update'])->name('profile.update');
    Route::get('/password', [CustomerController::class, 'editPassword'])->name('profile.password.edit');
    Route::patch('/password/update', [CustomerController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/delete', [CustomerController::class, 'destroy'])->name('profile.delete');
});

// Bookings
Route::get('/book/{username}', [BookingsController::class, 'booking_page'])->name('booking.view');
Route::get('/book/{username}/{date}', [BookingsController::class, 'booking_confirmation_page'])->name('booking.confirmation.view');




require __DIR__.'/auth.php';
