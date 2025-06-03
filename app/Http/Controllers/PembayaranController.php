<?php

//app/Http/Controllers/PembayaranController.php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        // Fetch pembayaran data along with the related student data
        $pembayarans = Pembayaran::with('student')->get();
        $bulanList = Pembayaran::select('bulan')->distinct()->pluck('bulan');
        $statusList = Pembayaran::select('status')->distinct()->pluck('status');

        // Return the data as JSON for the frontend
        return inertia('pembayaran', [
            'pembayaran' => $pembayarans,
            'bulanList' => $bulanList,
            'statusList' => $statusList,
        ]);
    }

    // Store a newly created resource
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'bulan' => 'required|string',
            'status' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'nominal' => 'required|numeric',
        ]);

        // Create new payment record
        $pembayaran = Pembayaran::create($request->all());

        // Return the created payment data
        return redirect()->route('pembayaran.index');
    }

    // Other actions: show, edit, update, destroy (not included here for brevity)
}
