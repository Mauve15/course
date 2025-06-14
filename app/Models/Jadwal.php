<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kelompok_id',
        'materi',
        'pengajar',
    ];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekaps()
    {
        return $this->hasMany(Rekap::class);
    }

    public function pengajarUser()
    {
        return $this->belongsTo(User::class, 'pengajar');
    }
}
