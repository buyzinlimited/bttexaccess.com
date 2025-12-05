<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Backend\AdvertiseController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\QuestionController;
use App\Http\Controllers\Backend\SeoContentController;

use App\Http\Controllers\Backend\CalibrationController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\BusinessSettingController;
use App\Http\Controllers\Frontend\FrontendProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Frontend Route
Route::get('/', [HomeController::class, 'index']);
Route::get('/cache/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize');

    // Manually clear views if necessary
    $viewsPath = storage_path('framework/views');
    foreach (glob("$viewsPath/*") as $viewFile) {
        unlink($viewFile);
    }

    // Reset Opcache
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }

    return redirect('dashboard')->with('status', 'Application cache cleared successfully!');
});
Route::get('/products', [FrontendProductController::class, 'allProducts']);
Route::get('/product/{slug}', [FrontendProductController::class, 'productDetail']);
Route::get('/get-box-one-products', [HomeController::class, 'boxOneProducts']);
Route::get('/get-box-two-products', [HomeController::class, 'boxTwoProducts']);
Route::get('/search', [FrontendProductController::class, 'searchProduct']);
Route::get('/send-inquiry', [InquiryController::class, 'sendInquiry']);
Route::post('/inquiry-message', [InquiryController::class, 'index']);
Route::post('/contact-message', [ContactController::class, 'index']);

Route::get('/category/{slug}', [FrontendProductController::class, 'categoryProduct']);
Route::get('/category/{mainCat}/{slug}', [FrontendProductController::class, 'subCategoryProduct']);

Route::get('/brand/{slug}', [FrontendProductController::class, 'brandProduct']);

Route::get('/contact', [HomeController::class, 'showContactPage']);
Route::get('/about', [HomeController::class, 'showAboutPage']);
Route::get('/calibrations', [HomeController::class, 'showCalibrationPage']);

Route::get('/get-product-title', [FrontendProductController::class, 'getTitle']);
Route::get('/get-all-products', [FrontendProductController::class, 'getAllProducts']);
Route::get('/get-brands', [FrontendProductController::class, 'getBrands']);
//Route::get('/get-categories', [FrontendProductController::class, 'getCategories']);
Route::get('/get-nav-cats', [FrontendProductController::class, 'getCategories']);


Route::get('/get-global-setting', [\App\Http\Controllers\Frontend\SettingController::class, 'getGlobalSetting']);



Route::middleware('auth')->group(function () {
    Route::get('/customer/profile', [ProfileController::class, 'customerProfile']);
    Route::resource('reviews', ReviewController::class);
    Route::resource('questions', QuestionController::class);
    Route::post('/create-answer/{id}', [QuestionController::class, 'update']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Dasshboard Route
Route::middleware(['auth', 'super.admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/products', [ProductController::class, 'index'])->name('product.all');
    Route::get('/dashboard/add-product', [ProductController::class, 'addProduct']);
    Route::get('/dashboard/edit-product/{slug}', [ProductController::class, 'editProduct']);

    Route::post('/store-product', [ProductController::class, 'storeProduct']);
    Route::post('/update-product/{slug}', [ProductController::class, 'updateProduct']);
    Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/delete-image/{id}', [ProductController::class, 'deleteProductImage']);

    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('abouts', AboutController::class);
    Route::resource('seocontents', SeoContentController::class);
    Route::resource('calibration', CalibrationController::class);
    Route::post('/update-category/{id}', [CategoryController::class, 'update']);
    Route::post('/update-sub-category/{id}', [SubCategoryController::class, 'update']);


    Route::resource('brands', BrandController::class);
    Route::post('/update-brand/{id}', [BrandController::class, 'update']);

    Route::resource('clients', ClientController::class);
    Route::post('/update-client/{id}', [ClientController::class, 'update']);

    Route::get('/dashboard/settings', [SettingsController::class, 'index'])->name('setting.index');
    Route::post('/save-setting', [BusinessSettingController::class, 'saveSettings']);
    Route::post('/save-logo-setting', [BusinessSettingController::class, 'logoUpdate']);


    Route::resource('pages', PageController::class);
    Route::resource('slider', SliderController::class);
    Route::post('/update-advertise/{id}', [AdvertiseController::class, 'update']);
    Route::resource('advertise', AdvertiseController::class);
    Route::post('/pages/update/{id}', [PageController::class, 'updatePage'])->name('pages.updatePage');


    Route::post('/update-top-bar-item/{id}', [BusinessSettingController::class, 'updateTopBarItem']);
    Route::post('/save-top-bar-items', [BusinessSettingController::class, 'saveTopBarItems']);
    Route::get('/delete-top-item/{id}', [BusinessSettingController::class, 'deleteTopItem']);
});





Route::get('/storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    dd('linked');
});


Route::get('/product-mail', function () {
    return view('emails.product-mail');
});

require __DIR__ . '/auth.php';
