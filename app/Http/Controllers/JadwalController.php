<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Jadwal;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pengajar') {
            // Pengajar hanya bisa melihat jadwal yang dia ajar
            $jadwals = Jadwal::with(['kelompok', 'pengajarUser:id,name'])
                ->where('pengajar', $user->id)
                ->get();
        } elseif ($user->role === 'siswa') {
            // Siswa: ambil kelompok_id dari tabel students
            $student = Student::where('user_id', $user->id)->first();
            $jadwals = $student
                ? Jadwal::with(['kelompok', 'pengajarUser:id,name'])
                ->where('kelompok_id', $student->kelompok_id)
                ->get()
                : collect(); // Kosong jika tidak ditemukan
        } else {
            // Admin (atau default): lihat semua jadwal
            $jadwals = Jadwal::with(['kelompok', 'pengajarUser:id,name'])->get();
        }

        return Inertia::render('jadwal', [
            'jadwals' => $jadwals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Silakan isi data jadwal']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelompok_id' => 'required|exists:kelompoks,id',
            'pengajar' => 'required|exists:users,id',
        ]);

        $jadwal = Jadwal::create($request->all());

        return response()->json($jadwal, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        return response()->json($jadwal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        return response()->json($jadwal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelompok_id' => 'required|exists:kelompoks,id',
            'pengajar' => 'required|exists:users,id',
        ]);

        $jadwal->update($request->all());

        return response()->json($jadwal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }
}
