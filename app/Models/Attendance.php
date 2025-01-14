<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag',
        'information',
        'status',
        'date',
        'time',
        'image_path'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'tag', 'uid_rfid');
    }
}
