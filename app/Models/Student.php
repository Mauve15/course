<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas',
        'asal_sekolah',
        'gender',
        'contact',
        'kelompok_id',

    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function rekaps()
    {
        return $this->hasMany(Rekap::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}
