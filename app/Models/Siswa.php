<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'nis', 'nama', 'no_absen', 'jurusan', 'kelas', 'uid_rfid', 'status', 'gambar'
    ];

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'nis', 'nis');
    }
}
