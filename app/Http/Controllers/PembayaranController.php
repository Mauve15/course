<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pengajar') {
            $kelompokIds = Jadwal::where('pengajar', $user->id)->pluck('kelompok_id');

            $pembayarans = Pembayaran::whereHas('student', function ($query) use ($kelompokIds) {
                $query->whereIn('kelompok_id', $kelompokIds);
            })->with('student')->get();
        } elseif ($user->role === 'siswa') {
            $pembayarans = Pembayaran::whereHas('student', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('student')->get();
        } else {
            $pembayarans = Pembayaran::with('student')->get();
        }

        // Ubah bulan dari kode ke nama bulan Indonesia
        $pembayarans->transform(function ($item) {
            $bulanKode = $item->bulan;

            // Kalau bulan sudah format '01' - '12', ubah jadi nama bulan
            $bulanMap = [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];

            $item->bulan = $bulanMap[$bulanKode] ?? $bulanKode;
            return $item;
        });

        $bulanList = $pembayarans->pluck('bulan')->unique()->values()->all();
        $statusList = $pembayarans->pluck('status')->unique()->values()->all();

        return inertia('pembayaran', [
            'pembayaran' => $pembayarans,
            'bulanList' => $bulanList,
            'statusList' => $statusList,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'status' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Pembayaran::create($request->all());

        return redirect()->route('pembayaran.index');
    }
}
