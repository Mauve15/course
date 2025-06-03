<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = ['bulan', 'status', 'student_id', 'nominal', 'keterangan'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
