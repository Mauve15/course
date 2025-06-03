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

Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    // Tambahan opsional:
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// routes/web.php

Route::prefix('pembayaran')->group(function () {
    // Menampilkan daftar pembayaran
    Route::get('/', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // Menyimpan data pembayaran baru
    Route::post('/', [PembayaranController::class, 'store'])->name('pembayaran.store');

    // (Opsional) Menampilkan detail pembayaran tertentu jika kamu tambahkan show()
    // Route::get('/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
