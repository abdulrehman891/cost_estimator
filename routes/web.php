<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\CompanyProfileController;

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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    // Product Routes
    Route::get('/product/list', [ProductController::class, 'index'])->name('product.list');
    Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');

    // Product Routes
    Route::get('/project/list', [ProjectController::class, 'index'])->name('project.list');
    Route::get('/project/show/{id}', [ProjectController::class, 'show'])->name('project.show');
    // Category Routes
    Route::get('/category/list', [ProductCategoryController::class, 'index'])->name('category.list');
    Route::get('/category/show/{id}', [ProductCategoryController::class, 'show'])->name('category.show');
    //Sub-Category Routes
    Route::get('/sub-category/list', [ProductSubCategoryController::class, 'index'])->name('sub-category.list');
    Route::get('/sub-category/show/{id}', [ProductSubCategoryController::class, 'show'])->name('sub-category.show');

    //Company Profile
    Route::get('/company-profile/show', [CompanyProfileController::class, 'show'])->name('company-profile.show');

    // Quotation Routes
    Route::get('/quotation/list', [QuotationController::class, 'index'])->name('quotation.list');

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
