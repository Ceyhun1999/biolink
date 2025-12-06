<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PatientExaminationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.patients.create');
    }
    return redirect()->route('admin.login');
});

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
});

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('admin.index');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('admin.login');
    })->name('admin.logout');

    Route::get('/patients', [PatientController::class, 'index'])->name('admin.patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('admin.patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('admin.patients.store');
    Route::get('/patients/edit/{patient}', [PatientController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/patients/update/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
    Route::post('/patient/{patient}/examination', [PatientExaminationController::class, 'store'])->name('admin.patients.examination.store');
    Route::delete('/patient/{patient}/examination/{examination}', [PatientExaminationController::class, 'destroy'])->name('admin.patients.examination.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('admin.settings.store');
});
