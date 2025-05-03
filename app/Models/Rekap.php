<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekap extends Model
{
    use HasFactory;

    protected $fillable = ['absen', 'score', 'keterangan', 'student_id', 'materi', 'jadwal_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
