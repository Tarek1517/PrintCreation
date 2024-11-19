<?php
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AdvertiseController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\FooterController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ManagerController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\HomeSectionController;
use App\Http\Controllers\Api\V1\ProductVariationController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\ShippingAreaController;
use App\Http\Controllers\Api\V1\SliderController;
use App\Http\Controllers\Api\V1\VariationController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ProductStockController;
use App\Http\Controllers\Api\V1\ProductReviewController;
use App\Http\Controllers\Api\Frontend\V1\HomeController;
use App\Http\Controllers\Api\Frontend\V1\ProductController as FrontendProductController;
use App\Http\Controllers\Api\Frontend\V1\CustomerController as FrontendCustomerController;
use App\Http\Controllers\Api\V1\CourierCompanyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Auth\Customer\AuthController;

//Mobile App Api
// Authentication
Route::post('/customer/login', [AuthController::class, 'login']);
Route::post('/customer/register', [AuthController::class, 'register']);

Route::get('/print-creation', [SettingController::class, 'getGlobalSetting']);
Route::prefix('frontend/v1')->middleware('throttle:api')->group( function() {
    Route::post('/save-review', [FrontendProductController::class, 'saveProductReview']);
    Route::get('/get-hero-slider', [HomeController::class, 'getHeroSlider']);    
    Route::get('/get-home-section', [HomeController::class, 'getHomeSection']);
    Route::get('/get-home-content', [HomeController::class, 'getHomeContent']);
    Route::get('/get-custom-page/{slug}', [HomeController::class, 'getCustomPage']);

    Route::post('/save-order', [OrderController::class, 'store']);
    Route::get('/category-product/{slug}', [FrontendProductController::class, 'getCategoryProduct']);
    Route::apiResource('product', FrontendProductController::class);
    Route::get('/get-search-product', [FrontendProductController::class, 'getSearchProduct']);

    Route::post('/save-request', [OrderController::class, 'saveOrderRequest']);
	
    
    Route::get('/get-all-category-list', [CategoryController::class, 'getAllCategoryList']);
    Route::get('/get-all-brand-list', [BrandController::class, 'getAllBrandList']);

    Route::post('/save-customer-address', [AddressController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/get-all-shipping-area-list', [ShippingAreaController::class, 'getAllShippingList']);
    Route::apiResource('address', AddressController::class)->middleware('auth:sanctum');
    Route::apiResource('courier-company', CourierCompanyController::class);
    Route::apiResource('customer', FrontendCustomerController::class)->middleware('auth:sanctum');
    Route::get('/show-customer-order/{id}', [FrontendCustomerController::class, 'showCustomerOrder']);
    Route::get('/get-customer-order', [FrontendCustomerController::class, 'getCustomerOrder']);
});
// authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('admin')->group( function() {
    Route::post('/create', [AdminAuthController::class, 'createAdmin']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/me', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::post('/logout', [AdminAuthController::class, 'logout']);
});

Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:api', 'type.admin'])->group( function () {

    Route::get('/dashboard', DashboardController::class);
    Route::get('/delete-product-image/{id}', [ProductController::class, 'deleteImage']);
    Route::get('/get-all-product-list', [ProductController::class, 'getAllProductList']);
    Route::get('/parent-category', [CategoryController::class, 'getParent']);
    Route::get('/get-all-category-list', [CategoryController::class, 'getAllCategoryList']);
    Route::get('/get-all-brand-list', [BrandController::class, 'getAllBrandList']);
    Route::get('/all-page-list', [PageController::class, 'allPageList']);
    Route::get('/setting', [SettingController::class, 'getAllSetting']);
    Route::post('/save-header-setting', [SettingController::class, 'saveHeaderSetting']);

    
    Route::get('/get-all-request', [OrderController::class, 'allRequest']);
    Route::get('/delete-request/{id}', [OrderController::class, 'deleteRequest']);

    Route::apiResources([
        'product' => ProductController::class,
        'product-variation' => ProductVariationController::class,
        'product-stock' => ProductStockController::class,
        'variation' => VariationController::class,
        'review' => ProductReviewController::class,
        'customer' => CustomerController::class,
        'manager' => ManagerController::class,
        'slider' => SliderController::class,
        'category' => CategoryController::class,
        'brand' => BrandController::class,
        'advertise' => AdvertiseController::class,
        'order' => OrderController::class,
        'page' => PageController::class,
        'shipping-area' => ShippingAreaController::class,
        'home-section' => HomeSectionController::class,
		'courier-company' => CourierCompanyController::class,
        'footer' => FooterController::class,
    ]);
});


Route::get("/storage", function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return "storage linked";
});