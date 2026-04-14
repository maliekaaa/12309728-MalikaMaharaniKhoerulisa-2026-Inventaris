<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LendingsController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Root redirect ke landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard umum (redirect sesuai role Admin)
    Route::middleware(['checkRole:admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard/admin', [DashboardController::class, 'AdminDashboard'])->name('admin.dashboard');

        // Categories
        Route::get('/category', [CategoriesController::class, 'index'])->name('category.index');
        Route::get('/category/create', [CategoriesController::class, 'create'])->name('category.create');
        Route::post('/category', [CategoriesController::class, 'store'])->name('category.store');
        Route::get('/category/{id}/edit', [CategoriesController::class, 'edit'])->name('category.edit');
        Route::put('/category/{id}', [CategoriesController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoriesController::class, 'destroy'])->name('category.delete');

        // Items (Admin)
        Route::get('/admin/items', [ItemsController::class, 'index'])->name('items.index');
        Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
        Route::get('/items/{id}/edit', [ItemsController::class, 'edit'])->name('items.edit');
        Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
        Route::delete('/items/{id}', [ItemsController::class, 'destroy'])->name('items.delete');
        Route::get('admin/items/export', [ItemsController::class, 'export'])->name('items.export');

        // Users – Admin
        Route::get('/users-admin', [UsersController::class, 'indexAdmin'])->name('users.admin');
        Route::get('/users-staff', [UsersController::class, 'indexStaff'])->name('users.staff');
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users-admin', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.delete');
        Route::post('/users/reset-password/{id}', [UsersController::class, 'resetPassword'])->name('users.reset');
        Route::get('/users/export', [UsersController::class, 'export'])->name('users.export');

        // Lendings (Admin view semua)
        Route::get('/admin/lendings', [LendingsController::class, 'adminIndex'])->name('admin.lendings.index');
    });

    // Dashboard dan fitur untuk staff
    Route::middleware(['checkRole:staff'])->group(function () {

        // Dashboard
        Route::get('/dashboard/staff', [DashboardController::class, 'StaffDashboard'])->name('staff.dashboard');

        // Items (Staff – read only)
        Route::get('/staff/items', [ItemsController::class, 'staffIndex'])->name('staff.items.index');

        // Lendings (Staff)
        Route::get('/lendings', [LendingsController::class, 'index'])->name('lendings.index');
        Route::get('/lendings/create', [LendingsController::class, 'create'])->name('lendings.create');
        Route::post('/lendings', [LendingsController::class, 'store'])->name('lendings.store');
        Route::post('/lendings/{id}/return', [LendingsController::class, 'return'])->name('lendings.return');
        Route::delete('/lendings/{id}', [LendingsController::class, 'destroy'])->name('lendings.destroy');
        Route::get('/lendings/export', [LendingsController::class, 'export'])->name('lendings.export');

        // Profile Staff
        Route::get('/profile/edit', [UsersController::class, 'editProfile'])->name('staff.profile.edit');
        Route::put('/profile/update', [UsersController::class, 'updateProfile'])->name('staff.profile.update');
    });
});
