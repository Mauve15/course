<?php

namespace App\Http\Controllers;

use App\Models\Rekap;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekaps = Rekap::with(['student', 'jadwal'])->get();

        return response()->json($rekaps);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Silakan isi data rekap']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'absen' => 'required',
            'score' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            'materi' => 'required|string',
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $rekap = Rekap::create($request->all());

        return response()->json($rekap, 201);
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
            'absen' => 'required',
            'score' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'student_id' => 'required|exists:students,id',
            'materi' => 'required|string',
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
