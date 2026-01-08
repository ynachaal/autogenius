<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TinyMCEController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BlogController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\FaqController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\BlogCategoryController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\SettingController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\UserController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\MenuController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\MenuCategoryController; // Ensure BlogController is imported
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [SiteController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Only accessible to users with role = 'admin'
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.') // <-- FIX: This line prefixes all routes inside with 'admin.'
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Create resources/views/admin/dashboard.blade.php
        })->name('dashboard'); // Now correctly named 'admin.dashboard'
		
		     Route::get('/migrate', [DashboardController::class, 'migrate'])->name('migrate');
        Route::get('/clearCache', [DashboardController::class, 'clearCache'])->name('clearCache');
    
        // Admin CRUD routes
        // This now correctly creates 'admin.blogs.index', 'admin.blogs.create', etc.
        Route::resource(name: 'blogs', controller: BlogController::class);
        Route::resource(name: 'faqs', controller: FaqController::class);
        Route::resource(name: 'pages', controller: PageController::class);
        Route::resource(name: 'users', controller: UserController::class);
         Route::resource(name: 'menus', controller: MenuController::class);
         Route::resource(name: 'menu-categories', controller: MenuCategoryController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource(name: 'blog-categories', controller: BlogCategoryController::class);

    });

/*
|--------------------------------------------------------------------------
| Front-End User Routes
|--------------------------------------------------------------------------
| Authenticated users with role = 'user'
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard'); // Create resources/views/dashboard.blade.php
    })->name('user.dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/tinymce-images', [TinyMCEController::class, 'images'])->name('tinymce.images');
Route::post('/tinymce-upload', [TinyMCEController::class, 'upload'])->name('tinymce.upload');