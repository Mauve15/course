<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tempat',
        'tanggal_lahir',
        'kelas',
        'asal_sekolah',
        'kelompok_id'
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function rekap()
    {
        return $this->hasMany(Rekap::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
