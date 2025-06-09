<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pembayaran;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Jadwal;
use App\Models\Rekap;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function create()
    {
        return Inertia::render('pendaftaran');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'kelompok_id' => 'required|exists:kelompoks,id',
        ]);

        // Cek apakah sudah terdaftar
        $existing = Registration::where('student_id', $validated['student_id'])
            ->where('kelompok_id', $validated['kelompok_id'])
            ->first();

        if ($existing) {
            return back()->with('message', 'Sudah terdaftar di kelas ini.');
        }

        Registration::create([
            'student_id' => $validated['student_id'],
            'kelompok_id' => $validated['kelompok_id'],
            'status' => 'belum aktif',
        ]);

        return back()->with('message', 'Pendaftaran berhasil, menunggu konfirmasi.');
    }

    public function updateStatus(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->status = $request->status;
        $registration->save();

        if ($registration->status === 'aktif') {
            // Tambah pembayaran otomatis
            Pembayaran::create([
                'student_id' => $registration->student_id,
                'bulan' => date('Y-m'),
                'nominal' => 100000,
                'status' => 'belum',
                'keterangan' => 'Pembayaran otomatis saat aktivasi',
            ]);

            $studentId = $registration->student_id;
            $kelompokId = $registration->kelompok_id;

            if (!$studentId || !$kelompokId) {
                return redirect()->back()->with('error', 'Student ID atau Kelompok ID tidak valid.');
            }

            $jadwals = Jadwal::where('kelompok_id', $kelompokId)->get();

            if ($jadwals->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada jadwal ditemukan untuk kelompok ini.');
            }

            foreach ($jadwals as $jadwal) {
                try {
                    $rekapCreated = Rekap::create([
                        'student_id' => $studentId,
                        'jadwal_id' => $jadwal->id,
                        'absen' => 0,
                        'score' => null,
                        'keterangan' => null,
                    ]);

                    if (!$rekapCreated) {
                        Log::warning("Gagal membuat rekap untuk student {$studentId}, jadwal {$jadwal->id}");
                    }
                } catch (\Exception $e) {
                    Log::error("Error insert Rekap: " . $e->getMessage());
                    return redirect()->back()->with('error', "Gagal simpan rekap: " . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('message', 'Status berhasil diperbarui dan data pembayaran + rekap dibuat.');
    }
}
