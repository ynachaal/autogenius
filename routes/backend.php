<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\{
    DashboardController,
    PageController,
    BrandController,
    ContactSubmissionController,
    ServiceController,
    ContentMetaController,
    BlogController,
    FaqController,
    BlogCategoryController,
    SettingController,
    UserController,
    MenuController,
	EmailTemplateController,
	SliderController,
	SliderCategoryController,
    MenuCategoryController
};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


      Route::get('content-meta/{section}', [ContentMetaController::class, 'index'])->name('content-meta.index');
        Route::post('content-meta/{section}/save', [ContentMetaController::class, 'saveMeta'])->name('content-meta.save');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/migrate', [DashboardController::class, 'migrate'])->name('migrate');
        Route::get('/clearCache', [DashboardController::class, 'clearCache'])->name('clearCache');

        Route::resource('contact-submissions', ContactSubmissionController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('blogs', BlogController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('pages', PageController::class);
        Route::resource('users', UserController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('slider-categories', SliderCategoryController::class);
        Route::resource('menus', MenuController::class);
		Route::resource('email-templates', EmailTemplateController::class);
        Route::resource('menu-categories', MenuCategoryController::class);
        Route::resource('blog-categories', BlogCategoryController::class);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    