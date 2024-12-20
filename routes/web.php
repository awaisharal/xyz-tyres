<?php


use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Shopkeeper\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Shopkeeper\ShopkeeperController;
use App\Http\Controllers\Shopkeeper\ServiceProviderController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\Shopkeeper\HolidayController;
use App\Http\Controllers\Shopkeeper\TemplateController;
use App\Models\Appointment;
use App\Notifications\ShopkeeperConfirmation;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\Auth;

//////////////////////////////////////////////////////////SHOPKEEPER ROUTES///////////////////////////////////////////////////////////

// Route::get('/', function () {
// return view('shopkeeper.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//about me
Route::get('/aboutme', function () {
    return view('shopkeeper.aboutme');
})->middleware(['auth', 'verified'])->name('aboutme');


Route::middleware('auth')->group(function () {
        //     about me
    //     Route::get('/aboutme', function () {
    //         return view('shopkeeper.aboutme');
    //     })->middleware(['auth', 'verified'])->name('aboutme');

        //dashboard
    Route::get('/', [ShopkeeperController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/sales', [ShopkeeperController::class, 'getSalesData'])->name('shopkeeper.sales');

        //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //shop schedule
    Route::get('/profile/schedule', [ProfileController::class, 'editSchedule'])->name('profile.schedule.edit'); // Edit Schedule
    Route::patch('/profile/schedule', [ProfileController::class, 'updateSchedule'])->name('profile.schedule.update');

    //services management 
    Route::get('/service', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/service', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/service/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/service/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/service/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    //templates 
    Route::get('/get-template-message', [ServiceController::class, 'getTemplateMessage'])->name('service.getTemplateMessage');
    Route::resource('templates', TemplateController::class)->except(['show', 'edit', 'create']);

    //holidays
    Route::resource('holidays', HolidayController::class)->except(['show', 'create', 'edit']);



    // Service Providers->shopkeepers
    Route::get('/service-providers', [ServiceProviderController::class, 'index'])->name('service-providers.index');
    Route::get('/service-providers/create', [ServiceProviderController::class, 'create'])->name('service-providers.create');
    Route::post('/service-providers', [ServiceProviderController::class, 'store'])->name('service-providers.store');
    Route::get('/service-providers/{serviceProvider}/edit', [ServiceProviderController::class, 'edit'])->name('service-providers.edit');
    Route::put('/service-providers/{serviceProvider}', [ServiceProviderController::class, 'update'])->name('service-providers.update');
    Route::delete('/service-providers/{serviceProvider}', [ServiceProviderController::class, 'destroy'])->name('service-providers.destroy');
    //appointments
    Route::get('/appointments', [ShopkeeperController::class, 'showAppointments'])->name('appointments');

    //customers
    Route::get('/customers', [ShopkeeperController::class, 'showCustomers'])->name('customers');
    //payments
    Route::get('/payments', [ShopkeeperController::class, 'showPayments'])->name('payments');
    //embedded link 
    // Update the route to use the company_slug instead of userSlug
    // Route::get('/embed/{companySlug}', [ShopkeeperController::class, 'showBookingWidget'])->name('embed.booking.widget');




});

Route::get('/embed/{company_slug}', [ShopkeeperController::class, 'showBookingWidget'])->name('embed.booking.widget');

/////////////////////////////////////////////////////////// CUSTOMER ROUTES /////////////////////////////////////////////////////////////

//public customer routes
Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    // Public Routes (Accessible without authentication)
    Route::get('/register', [CustomerController::class, 'register_view'])->name('register.view');
    Route::post('/register', [CustomerController::class, 'register'])->name('register');
    Route::get('/login', [CustomerController::class, 'login_view'])->name('login.view');
    Route::post('/login', [CustomerController::class, 'login'])->name('login');
    
    // Route::get('/service/{service}/book', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::get('{company_slug}/service/{service}/book', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::get('{user}/book', [AppointmentController::class, 'embedCreate'])->name('embed.appointment.create');

    Route::get('/shop/schedule/{userId}', [ProfileController::class, 'getSchedule'])->name('shop.schedule');
    Route::post('generate-qr', [ServiceController::class, 'generateQrCode'])->name('generateQr');

    // Services 
    Route::GET('/appointment/{service}/book', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/confirmation', [AppointmentController::class, 'confirmAppointment'])->name('confirm.appointment');
    Route::post('/appointments/store', [AppointmentController::class, 'store_appointment'])->name('store.appointment');

    // Protected Routes (Only accessible to logged-in customers)
    Route::middleware(['customers'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

        // Appointments
        Route::get('/appointments', [CustomerController::class, 'showAppointments'])->name('appointments.index');

        // Logout
        Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

        //profile        
        Route::get('/profile', [CustomerController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [CustomerController::class, 'update'])->name('profile.update');
        Route::get('/password', [CustomerController::class, 'editPassword'])->name('profile.password.edit');
        Route::patch('/password/update', [CustomerController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/delete', [CustomerController::class, 'destroy'])->name('profile.delete');

        //payments
    Route::get('/payments', [CustomerController::class, 'showPayments'])->name('payments');

    });

});
    //show services 
    Route::get('/services', [CustomerController::class, 'showServices'])->name('customer.services');
    //user email validation during appointment 
    Route::post('/check/user-email', [AppointmentController::class, 'check_userEmail'])->name('customer.checkEmail');
    Route::post('/login/validate', [AppointmentController::class, 'login_ValidateUser'])->name('customer.loginValidate');
    Route::post('/register/validate', [AppointmentController::class, 'register_ValidateUser'])->name('customer.registerValidate');
    //payment confirmation 
    Route::get('/payment/success', [AppointmentController::class, 'confirm_payment'])->name('payment.verify');
    Route::get('/payment/success/thankyou', [AppointmentController::class, 'showThankyou'])->name('payment.thankyou');


    ////////////////////////////////////////////////////////ADMIN ROUTES////////////////////////////////////////////////////////////////

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function ()
    {
        // Auth
        Route::get('login',[AdminController::class,'login'])->name('login');
        Route::post('login',[AdminController::class,'login_post'])->name('login.post');
        Route::get('logout',[AdminController::class,'logout'])->name('logout');

        // Dashboard
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');

        // Customers
        Route::get('customers/list',[AdminController::class,'customers'])->name('customer.list');
        Route::post('customer/update',[AdminController::class,'customer_update'])->name('customer.update');
        Route::post('customer/delete',[AdminController::class,'customer_delete'])->name('customer.delete');

        // Shopkeepers
        Route::get('shopkeepers/list',[AdminController::class,'shopkeepers'])->name('shopkeeper.list');
        Route::post('shopkeeper/update',[AdminController::class,'shopkeeper_update'])->name('shopkeeper.update');
        Route::post('shopkeeper/delete',[AdminController::class,'shopkeeper_delete'])->name('shopkeeper.delete');
        //permission toggle
        Route::post('/shopkeeper/toggle-permission', [AdminController::class, 'togglePermission'])->name('toggle-permission');


        // Appointments
        Route::get('appointments/list',[AdminController::class,'appointments'])->name('appointment.list');
        Route::post('appointment/delete',[AdminController::class,'appointments_delete'])->name('appointment.delete');

        //Payments
        Route::get('payments/list',[AdminController::class,'payments'])->name('payment.list');
    });
require __DIR__.'/auth.php';
