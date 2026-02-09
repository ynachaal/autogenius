<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\{
    CarInspectionController,
    DashboardController,
    ConsultationController,
    SellYourCarController,
    LeadController,
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
Route::get('/portal-8l2y1r', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route('admin.dashboard');
});
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('portal-8l2y1r')
    ->name('admin.')
    ->group(function () {


        Route::get('content-meta/{section}', [ContentMetaController::class, 'index'])->name('content-meta.index');
        Route::post('content-meta/{section}/save', [ContentMetaController::class, 'saveMeta'])->name('content-meta.save');



        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/migrate', [DashboardController::class, 'migrate'])->name('migrate');
        Route::get('/clearCache', [DashboardController::class, 'clearCache'])->name('clearCache');
        Route::get('/storage-link', [DashboardController::class, 'storageLink'])
            ->name('storage.link');

        Route::resource('leads', LeadController::class);
        Route::post('leads/{lead}/payments/{payment}/verify', [LeadController::class, 'verifyPayment'])
    ->name('leads.verify-payment');
        Route::resource('contact-submissions', ContactSubmissionController::class);
        Route::resource('sell-your-cars', SellYourCarController::class); 
         Route::resource('car-inspections', CarInspectionController::class); 
         Route::post('car-inspections/{car_inspection}/payments/{payment}/verify', [CarInspectionController::class, 'verifyPayment'])
    ->name('car-inspections.verify-payment');   
        Route::resource('consultations', ConsultationController::class);

        Route::post('consultations/{consultation}/status', [ConsultationController::class, 'updateStatus'])
            ->name('consultations.updateStatus');

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

