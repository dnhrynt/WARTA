<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\PostVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LikeController;

Route::get('/', [DashboardController::class, 'index'])->name('welcome');

    /* AUTH */
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    /* FORGOT & RESET PASSWORD */
    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::get('/reset-password', fn () => view('auth.reset-password'))->name('password.reset.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);



Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== ADMIN =====
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
            Route::prefix('users')->name('users.')->controller(UserManagementController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{user}/edit', 'edit')->name('edit');
                Route::put('/{user}', 'update')->name('update');
                Route::delete('/{user}', 'destroy')->name('destroy');
            });

            Route::prefix('posts')->name('posts.')->controller(PostVerificationController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{post}', 'show')->name('show');
                Route::put('/{post}/approve', 'approve')->name('approve');
                Route::put('/{post}/reject', 'reject')->name('reject');
            });

    });

    // ===== PROFILE =====
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    // ===== KATEGORI =====
    Route::prefix('kategori')->name('kategori.')->controller(KategoriController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{kategori}/edit', 'edit')->name('edit');
        Route::put('/{kategori}', 'update')->name('update');
        Route::delete('/{kategori}', 'destroy')->name('destroy');
    });

    // ===== POSTS =====
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/mine', [PostController::class, 'index'])->name('mine');
        Route::get('/create', [PostController::class, 'create'])->name('create');  
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    });

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');


});

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/{post}', [PostController::class, 'show'])->name('show');
});
Route::get('/author/{user}', [AuthorController::class, 'show'])->name('author.profile');
