<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\PembayaranController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::resource('students', StudentController::class);
Route::resource('kelompoks', KelompokController::class);
Route::resource('jadwals', JadwalController::class);
Route::resource('rekaps', RekapController::class);
Route::resource('pembayarans', PembayaranController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
