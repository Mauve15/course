<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompoks = Kelompok::all();

        return response()->json($kelompoks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Silakan isi data kelompok']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ]);

        $kelompok = Kelompok::create($request->all());

        return response()->json($kelompok, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Cari kelompok berdasarkan ID yang diberikan
        $kelompok = Kelompok::findOrFail($id);

        // Kembalikan data kelompok dalam format JSON
        return response()->json($kelompok);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Cari kelompok berdasarkan ID yang diberikan
        $kelompok = Kelompok::findOrFail($id);

        // Kembalikan data kelompok dalam format JSON
        return response()->json($kelompok);
    }

    /**
     * Update the specified resource in storage.
     */
    // app/Http/Controllers/KelompokController.php

    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_kelompok' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ]);

        // Cari kelompok berdasarkan ID yang diberikan
        $kelompok = Kelompok::findOrFail($id);

        // Update data kelompok dengan data dari request
        $kelompok->update($request->all());

        // Kembalikan data kelompok yang sudah diperbarui
        return response()->json($kelompok);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari kelompok berdasarkan ID yang diberikan
        $kelompok = Kelompok::findOrFail($id);

        // Hapus data kelompok
        $kelompok->delete();

        // Kembalikan respons JSON dengan pesan sukses
        return response()->json(['message' => 'Kelompok berhasil dihapus']);
    }
}
