<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KehadiranExport implements FromCollection, WithHeadings
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function collection()
    {
        return $this->attendances->map(function ($attendance) {
            return [
                'NIS' => $attendance->siswa->nis,
                'Nama' => $attendance->siswa->nama,
                'Kelas' => $attendance->siswa->kelas,
                'Tanggal' => $attendance->date,
                'Waktu Masuk' => $attendance->waktu_masuk,
                'Waktu Keluar' => $attendance->waktu_keluar,
                'Status' => $attendance->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Kelas',
            'Tanggal',
            'Waktu Masuk',
            'Waktu Keluar',
            'Status',
        ];
    }
}