<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use App\Models\Kelompok;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'siswa') {
            // Mahasiswa hanya lihat datanya sendiri
            $students = Student::with('kelompok')
                ->where('user_id', $user->id)
                ->get();
        } elseif ($user->role === 'pengajar') {
            // Pengajar hanya lihat siswa dari kelompok yang dia ajar
            $kelompokIds = \App\Models\Jadwal::where('pengajar', $user->id)->pluck('kelompok_id');

            $students = Student::with('kelompok')
                ->whereIn('kelompok_id', $kelompokIds)
                ->get();
        } else {
            // Admin bisa lihat semua siswa
            $students = Student::with('kelompok')->get();
        }

        return Inertia::render('student', [
            'students' => $students,
        ]);
    }

    public function create()
    {
        // Kita kirim juga data kelompok ke view supaya bisa dipilih di form
        $kelompoks = Kelompok::all();

        return Inertia::render('pendaftaran', [
            'kelompoks' => $kelompoks,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required|string|max:50',
            'asal_sekolah' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'contact' => 'required|string|max:50',
            // 'kelompok_id' => 'null|exists:kelompoks,id', // jika ada input kelompok
        ]);

        // Simpan student
        $student = Student::create([
            ...$validated,
            'kelompok_id' => null,
            'user_id' => Auth::user()->id, // ✅ benar

        ]);

        // Buat registration otomatis dengan status 'belum'
        Registration::create([
            'student_id' => $student->id,
            'kelompok_id' => null,
            'status' => 'belum aktif', // status awal belum aktif
        ]);

        return redirect()->route('create')->with('message', 'Pendaftaran berhasil! Tunggu konfirmasi admin.');
    }
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'role' => 'required|in:siswa,admin,guru', // dll
        ]);

        // Update data student
        $student->update($request->all());

        // Sinkronkan role ke tabel users
        $student->user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }
}
