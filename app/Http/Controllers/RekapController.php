<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Rekap;
use App\Models\Jadwal;
use App\Models\Student;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // di controller
    public function index()
    {
        $rekaps = Rekap::with(['student', 'jadwal'])->get();
        $students = Student::select('id', 'nama')->get();
        $jadwals = Jadwal::select('id', 'materi')->get();

        return Inertia::render('rekap', [
            'rekaps' => $rekaps,
            'students' => $students,
            'jadwals' => $jadwals,
        ]);
    }

    public function create()
    {
        return Inertia::render('rekap', [
            'students' => Student::select('id', 'name')->get(),
            'jadwals' => Jadwal::select('id', 'name')->get(),
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        return response()->json($rekap);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        return response()->json($rekap);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rekap = Rekap::findOrFail($id);
        $request->validate([
            'absen' => 'required|integer|min:0',
            'score' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            // 'materi' => 'required|string',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $rekap->update($request->all());

        return response()->json($rekap);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rekap = Rekap::findOrFail($id);
        $rekap->delete();

        return response()->json(['message' => 'Rekap berhasil dihapus']);
    }
}
