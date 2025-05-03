<?php
// app/Http/Controllers/PembayaranController.php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('student')->get();

        return response()->json($pembayarans);
    }

    public function create()
    {
        return response()->json(['message' => 'Silakan isi data pembayaran']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'status' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'nominal' => 'required|numeric',
        ]);

        $pembayaran = Pembayaran::create($request->all());

        return response()->json($pembayaran, 201);
    }

    public function show(Pembayaran $pembayaran)
    {
        return response()->json($pembayaran);
    }

    public function edit(Pembayaran $pembayaran)
    {
        return response()->json($pembayaran);
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'bulan' => 'required|string',
            'status' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'nominal' => 'required|numeric',
        ]);

        $pembayaran->update($request->all());

        return response()->json($pembayaran);
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran berhasil dihapus']);
    }
}
