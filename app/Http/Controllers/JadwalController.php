<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pastikan eager load relasi kelompok (dan guru jika perlu)
        $jadwals = Jadwal::with(['kelompok', 'user'])->get();

        return Inertia::render('jadwal', [
            'jadwals' => Jadwal::with(['kelompok', 'user:id,name'])->get(),
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
            'user_id' => 'required|exists:users,id',
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
            'user_id' => 'required|exists:users,id',
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
