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

Route::get('/landing', function () {
    return view('landing');
});
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Admin & Staff)


// Routes untuk Admin
Route::middleware(['auth'])->group(function () {
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

        // Users – Admin
        Route::get('/users-admin', [UsersController::class, 'indexAdmin'])->name('users.admin');
        Route::get('/users-staff', [UsersController::class, 'indexStaff'])->name('users.staff');
        Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('/users-admin', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.delete');
        Route::post('/users/reset-password/{id}', [UsersController::class, 'resetPassword'])->name('users.reset');

        // Lendings (Admin view semua)
        Route::get('/admin/lendings', [LendingsController::class, 'adminIndex'])->name('admin.lendings.index');
    });
});
