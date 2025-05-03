<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kelompok', 'hari', 'jam'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
