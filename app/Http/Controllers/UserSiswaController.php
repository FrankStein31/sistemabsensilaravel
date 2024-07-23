<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Attendance;
use App\Models\StudentAttendance;

class UserSiswaController extends Controller
{
    // public function index()
    // {
    //     // Fetch the logged-in student's data
    //     $student = Auth::guard('student')->user();
    
    //     // Fetch counts for attendance statuses based on uid_rfid from attendances table
    //     $hadir = Attendance::where('tag', $student->uid_rfid)
    //                        ->whereIn('information', ['in', 'out'])
    //                        ->distinct('date')
    //                        ->count();
    
    //     // Fetch counts for sakit, izin, and alpha from student_attendances table
    //     $studentAttendances = StudentAttendance::where('nis', $student->nis)
    //                                            ->selectRaw('status, COUNT(*) as count')
    //                                            ->groupBy('status')
    //                                            ->pluck('count', 'status')
    //                                            ->toArray();
    
    //     $sakit = $studentAttendances['sakit'] ?? 0;
    //     $izin = $studentAttendances['izin'] ?? 0;
    //     $alpha = $studentAttendances['alpha'] ?? 0;
    
    //     // Fetch the latest 5 attendance records for the logged-in student
    //     $riwayat = Attendance::where('tag', $student->uid_rfid)
    //                          ->orderBy('date', 'desc')
    //                          ->orderBy('time', 'desc')
    //                          ->take(5)
    //                          ->get();
    
    //     return view('student.dashboard', compact('student', 'hadir', 'sakit', 'izin', 'alpha', 'riwayat'));
    // }

    public function index(Request $request)
    {
        $student = Auth::guard('student')->user();
        $selectedMonth = $request->input('month', now()->format('Y-m'));
    
        // Fetch counts for attendance statuses based on uid_rfid from attendances table
        $hadir = Attendance::where('tag', $student->uid_rfid)
                           ->whereIn('information', ['in', 'out'])
                           ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$selectedMonth])
                           ->distinct('date')
                           ->count();
    
        // Fetch counts for sakit, izin, and alpha from student_attendances table
        $studentAttendances = StudentAttendance::where('nis', $student->nis)
                                               ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
                                               ->selectRaw('status, COUNT(*) as count')
                                               ->groupBy('status')
                                               ->pluck('count', 'status')
                                               ->toArray();
    
        $sakit = $studentAttendances['sakit'] ?? 0;
        $izin = $studentAttendances['izin'] ?? 0;
        $alpha = $studentAttendances['alpha'] ?? 0;
    
        // Fetch the latest 5 attendance records for the logged-in student
        $riwayat = Attendance::where('tag', $student->uid_rfid)
                             ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$selectedMonth])
                             ->orderBy('date', 'desc')
                             ->orderBy('time', 'desc')
                             ->take(5)
                             ->get();
    
        // Generate list of months for the dropdown
        $monthsList = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $monthsList[$date->format('Y-m')] = $date->format('F Y');
        }
    
        return view('student.dashboard', compact('student', 'hadir', 'sakit', 'izin', 'alpha', 'riwayat', 'selectedMonth', 'monthsList'));
    }

    // public function kehadiran(Request $request)
    // {
    //     // Fetch the logged-in student's data
    //     $student = Auth::guard('student')->user();

    //     // Initial query to fetch attendance records
    //     $query = Attendance::where('tag', $student->uid_rfid)->orderBy('date', 'desc');

    //     // Check if there is a search query for tanggal presensi
    //     if ($request->has('tanggal')) {
    //         $query->whereDate('date', $request->tanggal);
    //     }

    //     // Fetch the attendance records based on the query
    //     $riwayat = $query->get();

    //     // Fetch the student's photo
    //     $photo = $student->gambar;

    //     // Loop through each attendance record and fetch the time information
    //     foreach ($riwayat as $presensi) {
    //         // Ambil waktu masuk
    //         $waktuMasuk = Attendance::where('tag', $student->uid_rfid)
    //             ->where('date', $presensi->date)
    //             ->where('information', 'in')
    //             ->first();

    //         // Ambil waktu keluar
    //         $waktuKeluar = Attendance::where('tag', $student->uid_rfid)
    //             ->where('date', $presensi->date)
    //             ->where('information', 'out')
    //             ->first();

    //         // Assign waktu masuk dan waktu keluar ke dalam objek presensi
    //         $presensi->waktu_masuk = $waktuMasuk ? $waktuMasuk->time : null;
    //         $presensi->waktu_keluar = $waktuKeluar ? $waktuKeluar->time : null;
    //     }

    //     return view('student.riwayatPresensi', compact('riwayat', 'photo'));
    // }
    // public function kehadiran(Request $request)
    // {
    //     $student = Auth::guard('student')->user();
    //     $query = Attendance::where('tag', $student->uid_rfid)
    //                     ->orderBy('date', 'desc');

    //     if ($request->has('tanggal')) {
    //         $query->whereDate('date', $request->tanggal);
    //     }

    //     $attendances = $query->get()
    //         ->groupBy('date')
    //         ->map(function ($group) {
    //             $waktuMasuk = $group->where('information', 'in')->first();
    //             $waktuKeluar = $group->where('information', 'out')->first();
                
    //             return [
    //                 'date' => $group->first()->date,
    //                 'waktu_masuk' => $waktuMasuk ? $waktuMasuk->time : null,
    //                 'waktu_keluar' => $waktuKeluar ? $waktuKeluar->time : null,
    //                 'image_masuk' => $waktuMasuk ? $waktuMasuk->image_path : null,
    //                 'image_keluar' => $waktuKeluar ? $waktuKeluar->image_path : null,
    //                 'status' => $this->determineStatus($waktuMasuk, $waktuKeluar)
    //             ];
    //         });

    //     return view('student.riwayatPresensi', compact('attendances'));
    // }
    public function kehadiran(Request $request)
    {
        $student = Auth::guard('student')->user();
        $query = Attendance::where('tag', $student->uid_rfid)
                        ->orderBy('date', 'desc');

        if ($request->has('tanggal')) {
            $query->whereDate('date', $request->tanggal);
        }

        $attendances = $query->get()
            ->groupBy('date')
            ->map(function ($group) {
                $waktuMasuk = $group->where('information', 'in')->first();
                $waktuKeluar = $group->where('information', 'out')->first();
                
                return [
                    'date' => $group->first()->date,
                    'waktu_masuk' => $waktuMasuk ? $waktuMasuk->time : null,
                    'waktu_keluar' => $waktuKeluar ? $waktuKeluar->time : null,
                    'image_masuk' => $waktuMasuk ? $waktuMasuk->image_path : null,
                    'image_keluar' => $waktuKeluar ? $waktuKeluar->image_path : null,
                    'status' => $this->determineStatus($waktuMasuk, $waktuKeluar),
                    'type' => 'attendance'
                ];
            });

        // Fetch student_attendances records
        $studentAttendancesQuery = StudentAttendance::where('nis', $student->nis)
            ->orderBy('tanggal', 'desc');

        if ($request->has('tanggal')) {
            $studentAttendancesQuery->whereDate('tanggal', $request->tanggal);
        }

        $studentAttendances = $studentAttendancesQuery->get()
            ->map(function ($attendance) {
                return [
                    'date' => $attendance->tanggal->toDateString(),
                    'waktu_masuk' => null,
                    'waktu_keluar' => null,
                    'image_masuk' => null,
                    'image_keluar' => null,
                    'status' => ucfirst($attendance->status),
                    'gambar' => $attendance->gambar,
                    'type' => 'student_attendance'
                ];
            });

        // Merge and sort all attendance records
        $allAttendances = $attendances->merge($studentAttendances)->sortByDesc('date');

        return view('student.riwayatPresensi', compact('allAttendances'));
    }

    private function determineStatus($waktuMasuk, $waktuKeluar)
    {
        if ($waktuMasuk && $waktuKeluar) {
            return 'Hadir';
        } elseif ($waktuMasuk) {
            return 'Masuk';
        } elseif ($waktuKeluar) {
            return 'Pulang';
        } else {
            return 'Tidak Hadir';
        }
    }
}
