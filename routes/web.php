<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Middleware\Subscribed;
use App\Http\Controllers\PaymentsContoller;
use App\Http\Controllers\StripeResponseHookHandler;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JLSignnowHelpersController;
use App\Http\Controllers\ProductPriceHistoryController;


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

Route::middleware(['auth', 'twofactor'])->group(function () {
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::get('verify/check', [TwoFactorController::class, 'store'])->name('verify.check');
    Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
});

Route::post('/stripre_hook_handler', [StripeResponseHookHandler::class, 'handleWebhook']);
Route::post('/signnow_hook_handler', [JLSignnowHelpersController::class, 'handleWebhook']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'twofactor']);


    Route::get('/packages', [PaymentsContoller::class, 'Packages']);
    Route::get('/pruchase_package', [PaymentsContoller::class, 'doPackagePurchase'])->name('pruchase_package');
    Route::get('/pruchase_thankyou', [PaymentsContoller::class, 'Pruchase_Thankyou'])->name('pruchase_thankyou');
    Route::get('/pruchase_failed', [PaymentsContoller::class, 'Pruchase_Failed'])->name('pruchase_failed');


    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'twofactor'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    // Product Routes
    Route::get('/product/list', [ProductController::class, 'index'])->name('product.list');
    Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');

    // Product Price History Routes
    Route::get('/product-price-history/list', [ProductPriceHistoryController::class, 'index'])->name('product-price-history.list');
    Route::get('/product-price-history/show/{id}', [ProductPriceHistoryController::class, 'show'])->name('product-price-history.show');

    // Product Routes
    Route::get('/project/list', [ProjectController::class, 'index'])->name('project.list');
    Route::get('/project/show/{id}', [ProjectController::class, 'show'])->name('project.show');
    // Category Routes
    Route::get('/category/list', [ProductCategoryController::class, 'index'])->name('category.list');
    Route::get('/category/show/{id}', [ProductCategoryController::class, 'show'])->name('category.show');

    // Customer Routes
    Route::get('/customer/list', [CustomerController::class, 'index'])->name('customer.list');
    Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');

    //Sub-Category Routes
    Route::get('/sub-category/list', [ProductSubCategoryController::class, 'index'])->name('sub-category.list');
    Route::get('/sub-category/show/{id}', [ProductSubCategoryController::class, 'show'])->name('sub-category.show');

    //Company Profile
    Route::get('/company-profile/show', [CompanyProfileController::class, 'show'])->name('company-profile.show');

    // Quotation Routes
    Route::get('/quotation/list', [QuotationController::class, 'index'])->name('quotation.list')->middleware([Subscribed::class]);
    Route::get('/quotation/download/{id}', [QuotationController::class, 'downloadProposal'])->name('qoutation.download');
    Route::get('/quotation/preview_doc/{signnow_document_id}', [JLSignnowHelpersController::class, 'previewDoc'])->name('qoutation.preview_doc');
    Route::get('/quotation/send/{id}', [QuotationController::class, 'sendProposal'])->name('qoutation.send');

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
