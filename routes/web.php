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
Route::get('/b/{token}', [PaktaController::class, 'shortPdf'])
    ->name('pakta.short.pdf');
Route::get('/pakta', [PaktaController::class, 'index'])->name('pakta');
Route::post('/pakta', [PaktaController::class, 'store'])->name('pakta.store');
Route::get('/bukti-pakta/{pakta}', [
    PaktaController::class,
    'publicPdf',
])->middleware('signed:relative')->name('pakta.public.pdf');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');


Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])
        ->name('admin.dashboard.stats');

    Route::get('/pengisi-pakta', [AdminDashboardController::class, 'pengisiPakta'])
        ->name('admin.pengisi-pakta');

    Route::get('/pakta/{pakta}/penilaian', [AdminDashboardController::class, 'formPenilaian'])
        ->name('admin.pakta.penilaian');

    Route::post('/pakta/{pakta}/penilaian', [AdminDashboardController::class, 'storePenilaian'])
        ->name('admin.pakta.penilaian.store');

    Route::get('/penilaian/{penilaian}/download', [AdminDashboardController::class, 'downloadPenilaian'])
        ->name('admin.penilaian.download');

    Route::get('/penilaian/{penilaian}/view', [AdminDashboardController::class, 'viewPenilaian'])
        ->name('admin.penilaian.view');

    Route::get('/pakta/{pakta}/download', [PaktaController::class, 'download'])
        ->name('admin.pakta.download');

    Route::get('/pakta/{pakta}/view', [PaktaController::class, 'view'])
        ->name('admin.pakta.view');

    Route::get('/logout', [AdminAuthController::class, 'showLogout'])
        ->name('admin.logout.confirm');

    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');
});