<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('kelompok')->get();

        return Inertia::render('student', [
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelompoks = Kelompok::all();

        return Inertia::render('Student/Create', [
            'kelompoks' => $kelompoks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat' => 'required',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required',
            'asal_sekolah' => 'required',
            'kelompok_id' => 'required|exists:kelompoks,id',
        ]);

        Student::create($request->all());

        return redirect()->route('student.index')->with('message', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Pastikan data mahasiswa ditemukan
        $student = Student::findOrFail($id);  // gunakan findOrFail agar data student harus ada

        // Ambil data kelompok
        $kelompoks = Kelompok::all();

        // Kirim ke Inertia
        return Inertia::render('Student/Edit', [
            'student' => $student,
            'kelompoks' => $kelompoks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'tempat' => 'required',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required',
            'asal_sekolah' => 'required',
            'kelompok_id' => 'required|exists:kelompoks,id',
        ]);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('student.index')->with('message', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.index')->with('message', 'Data siswa berhasil dihapus');
    }
}
