<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaktaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return view('pakta');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

Route::get('/pakta', [PaktaController::class, 'index'])->name('pakta');
Route::post('/pakta', [PaktaController::class, 'store'])->name('pakta.store');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('admin.dashboard.stats');
    Route::get('/pengisi-pakta', [AdminDashboardController::class, 'pengisiPakta'])->name('admin.pengisi-pakta');
    Route::get('/pakta/{pakta}/download', [PaktaController::class, 'download'])->name('admin.pakta.download');

    Route::get('/logout', [AdminAuthController::class, 'showLogout'])->name('admin.logout.confirm');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});