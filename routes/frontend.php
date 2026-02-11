<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ServiceInsuranceClaimController;
use App\Http\Controllers\CallConsultationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactSubmissionController;
use App\Http\Controllers\TinyMCEController;
use App\Http\Controllers\SellYourCarController;
use App\Http\Controllers\CarInspectionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Frontend User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('contact')
    ->name('frontend.contact.')
    ->group(function () {

        Route::get('/', [ContactSubmissionController::class, 'create'])
            ->name('create');

        Route::post('/', [ContactSubmissionController::class, 'store'])
            ->name('store');
    });

/*
|--------------------------------------------------------------------------
| TinyMCE (shared / frontend usage)
|--------------------------------------------------------------------------
*/
Route::get('/queue', [SiteController::class, 'queue'])->name('queue');
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/{slug}', [SiteController::class, 'pageDetail'])->name('show'); // single page
});
Route::get('/services', [SiteController::class, 'services'])
    ->name('services.index');

Route::get('/car-deliveries', [SiteController::class, 'carDeliveries'])->name('car.deliveries');


Route::get('/smart-car-requirements', [LeadController::class, 'index'])->name('lead.index');

// Add this to handle the form data
Route::post('/smart-car-requirements', [LeadController::class, 'store'])->name('lead.store');

Route::get('/search', [SiteController::class, 'search'])->name('search');

Route::get('/services/{slug}', [SiteController::class, 'serviceDetail'])->name('services.show');
Route::get('/queue', [SiteController::class, 'queue'])->name('queue');
Route::get('/tinymce-images', [TinyMCEController::class, 'images'])->name('tinymce.images');
Route::post('/tinymce-upload', [TinyMCEController::class, 'upload'])->name('tinymce.upload');





Route::get('/lead/payment/{lead}', [LeadController::class, 'payment'])
    ->name('lead.payment')
    ->middleware('signed');

Route::post('/lead/payment/verify', [LeadController::class, 'verifyPayment'])->name('lead.payment.verify');

// sell car routes
Route::post('/sell-car/submit', [SellYourCarController::class, 'store'])->name('car.submit');

// inspection routes

Route::post('/pdi/submit', [CarInspectionController::class, 'store'])
    ->name('pdi.submit');

// The payment page (Signed for security)
Route::get('/inspection/payment/{inspection}', [CarInspectionController::class, 'payment'])
    ->name('inspection.payment')
    ->middleware('signed');

// The Razorpay verification callback
Route::post('/inspection/payment/verify', [CarInspectionController::class, 'verifyPayment'])
    ->name('inspection.payment.verify');

// Success and Failure pages

Route::post('/service-insurance/submit', [ServiceInsuranceClaimController::class, 'store'])
    ->name('service-insurance.submit');

Route::get('/service-insurance/payment/{insurance}', [ServiceInsuranceClaimController::class, 'payment'])
    ->name('service-insurance.payment')
    ->middleware('signed');

Route::post('/service-insurance/payment/verify', [ServiceInsuranceClaimController::class, 'verifyPayment'])
    ->name('service-insurance.payment.verify');


    Route::post('/call-consultation/submit', [CallConsultationController::class, 'store'])
    ->name('service.submit'); // Matches the action name in your Blade form

// The payment page (Signed for security)
Route::get('/call-consultation/payment/{consultation}', [CallConsultationController::class, 'payment'])
    ->name('call-consultation.payment')
    ->middleware('signed');

// The Razorpay verification callback
Route::post('/call-consultation/payment/verify', [CallConsultationController::class, 'verifyPayment'])
    ->name('call-consultation.payment.verify');



Route::view('/payment/success', 'front.payments.success')->name('payment.success');
Route::view('/payment/failed', 'front.payments.failed')->name('payment.failed');


Route::get('/about', [SiteController::class, 'about'])->name('about');