<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Rekap;
use App\Models\Jadwal;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'siswa') {
            $student = Student::where('user_id', $user->id)->first();

            $rekaps = Rekap::with(['student', 'jadwal'])
                ->where('student_id', $student->id)
                ->get();

            return Inertia::render('rekap', [
                'rekaps' => $rekaps,
                'students' => [],
                'jadwals' => [],
                'users' => $user,
            ]);
        }

        if ($user->role === 'guru') {
            $jadwals = Jadwal::where('pengajar', $user->id)->select('id', 'materi', 'kelompok_id')->get();
            $kelompokIds = $jadwals->pluck('kelompok_id')->unique();
            $students = Student::whereIn('kelompok_id', $kelompokIds)->select('id', 'nama')->get();
            $rekaps = Rekap::with(['student', 'jadwal'])
                ->whereHas('jadwal', fn($q) => $q->where('pengajar', $user->id))
                ->get();

            return Inertia::render('rekap', [
                'rekaps' => $rekaps,
                'students' => $students,
                'jadwals' => $jadwals->makeHidden('kelompok_id'),
                'users' => $user,
            ]);
        }

        // === ADMIN ===
        $rekaps = Rekap::with(['student', 'jadwal'])->get();
        $students = Student::select('id', 'nama')->get();
        $jadwals = Jadwal::select('id', 'materi')->get();

        return Inertia::render('rekap', [
            'rekaps' => $rekaps,
            'students' => $students,
            'jadwals' => $jadwals,
            'users' => $user,
        ]);
    }



    public function create()
    {
        $user = Auth::user()->id;


        // Ambil jadwal milik pengajar
        $jadwals = Jadwal::where('pengajar', $user->id)->select('id', 'materi', 'kelompok_id')->get();
        $kelompokIds = $jadwals->pluck('kelompok_id')->unique();

        // Ambil siswa dari kelompok tersebut
        $students = Student::whereIn('kelompok_id', $kelompokIds)->select('id', 'nama')->get();

        return Inertia::render('rekap', [
            'students' => $students,
            'jadwals' => $jadwals->makeHidden('kelompok_id'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'absen' => 'required|integer|min:0',
            'score' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        Rekap::create($request->all());

        return redirect()->route('rekap.index')->with('success', 'Rekap berhasil disimpan');
    }

    public function show(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        return response()->json($rekap);
    }

    public function edit(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        return response()->json($rekap);
    }

    public function update(Request $request, string $id)
    {
        $rekap = Rekap::findOrFail($id);

        $request->validate([
            'absen' => 'required|integer|min:0',
            'score' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $rekap->update($request->all());

        return response()->json($rekap);
    }

    public function destroy(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        $rekap->delete();

        return response()->json(['message' => 'Rekap berhasil dihapus']);
    }
}
