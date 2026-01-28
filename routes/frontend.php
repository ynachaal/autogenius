<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactSubmissionController;
use App\Http\Controllers\TinyMCEController;

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

Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/{slug}', [SiteController::class, 'pageDetail'])->name('show'); // single page
});
Route::get('/services', [SiteController::class, 'services'])
    ->name('services.index');

Route::get('/car-deliveries', [SiteController::class, 'carDeliveries'])->name('car.deliveries');

Route::get('/search', [SiteController::class, 'search'])->name('search');

Route::get('/services/{slug}', [SiteController::class, 'serviceDetail'])->name('services.show');
Route::get('/queue', [SiteController::class, 'queue'])->name('queue');
Route::get('/tinymce-images', [TinyMCEController::class, 'images'])->name('tinymce.images');
Route::post('/tinymce-upload', [TinyMCEController::class, 'upload'])->name('tinymce.upload');
