<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;


Route::get('/', function () {
    return redirect()->route('login'); // langsung redirect ke login
});

// Auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');


Route::middleware(['auth'])->group(function () {

    // Dashboard utama
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Group Admin
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Shop (CRUD + dummy)
        Route::resource('shop', ShopController::class);
        Route::patch('shop/{product}/toggle-status', [ShopController::class, 'toggleStatus'])->name('shop.toggle-status');
        Route::get('shop/create-dummy', [ShopController::class, 'createDummy'])->name('shop.createDummy');
        Route::post('shop/store-dummy', [ShopController::class, 'storeDummy'])->name('shop.storeDummy');

        // Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

        // Brand (dummy view)
        Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
        Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');

        // Users (pakai resource biar lengkap CRUD)
        Route::resource('user', UserController::class);

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Pages (dummy)
        Route::get('/pages', function () {
            return view('admin.pages.index');
        })->name('pages.index');

        Route::get('/pages/create', function () {
            return view('admin.pages.create');
        })->name('pages.create');
    });
});
