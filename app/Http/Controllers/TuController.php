<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KehadiranExport;
use App\Models\StudentAttendance;
use App\Models\Setting;
use Carbon\Carbon;

class TuController extends Controller
{
    // public function dashboard()
    // {
    //     $total_siswa = Siswa::count();
    //     $hadir = Siswa::where('status', 'hadir')->count();
    //     $sakit = Siswa::where('status', 'sakit')->count();
    //     $izin = Siswa::where('status', 'izin')->count();
    //     $alpha = Siswa::where('status', 'alpha')->count();

    //     return view('admin_tu.dashboard', compact('total_siswa', 'hadir', 'sakit', 'izin', 'alpha'));
    // }
    // public function dashboard()
    // {
    //     $today = now()->toDateString(); // Get today's date
    //     $total_siswa = Siswa::count();
        
    //     $attendances = Attendance::select('tag', 'date')
    //         ->selectRaw('MAX(information) as information')
    //         ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
    //         ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
    //         ->whereDate('date', $today)
    //         ->groupBy('tag', 'date')
    //         ->get()
    //         ->filter(function($attendance) {
    //             return $attendance->siswa !== null;
    //         })
    //         ->map(function($attendance) {
    //             $attendance->status = $this->determineStatus($attendance->waktu_masuk, $attendance->waktu_keluar, $attendance->information);
    //             return $attendance;
    //         });

    //     $hadir = $attendances->filter(function($attendance) {
    //         return $attendance->status === 'Hadir';
    //     })->count();

    //     $masuk = $attendances->filter(function($attendance) {
    //         return $attendance->status === 'Masuk';
    //     })->count();

    //     $pulang = $attendances->filter(function($attendance) {
    //         return $attendance->status === 'Pulang';
    //     })->count();

    //     $sakit = StudentAttendance::where('status', 'sakit')
    //                             ->whereDate('created_at', $today)
    //                             ->count();

    //     $izin = StudentAttendance::where('status', 'izin')
    //                             ->whereDate('created_at', $today)
    //                             ->count();

    //     // Fetch alpha count directly from the database
    //     $alpha = StudentAttendance::where('status', 'alpha')
    //                             ->whereDate('created_at', $today)
    //                             ->count();

    //     // Calculate tidak_hadir as the remaining students
    //     $tidak_hadir = $total_siswa - ($hadir + $masuk + $pulang + $sakit + $izin + $alpha);

    //     return view('admin_tu.dashboard', compact('total_siswa', 'hadir', 'masuk', 'pulang', 'tidak_hadir', 'sakit', 'izin', 'alpha'));
    // }

    public function dashboard(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $total_siswa = Siswa::count();
        
        $attendances = Attendance::select('tag')
            ->selectRaw('DATE(date) as date')
            ->selectRaw('MAX(information) as information')
            ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
            ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
            ->whereRaw('DATE_FORMAT(date, "%Y-%m") = ?', [$selectedMonth])
            ->groupBy('tag', 'date')
            ->get()
            ->filter(function($attendance) {
                return $attendance->siswa !== null;
            })
            ->map(function($attendance) {
                $attendance->status = $this->determineStatus($attendance->waktu_masuk, $attendance->waktu_keluar, $attendance->information);
                return $attendance;
            });

        $hadir = $attendances->filter(function($attendance) {
            return $attendance->status === 'Hadir';
        })->count();

        $masuk = $attendances->filter(function($attendance) {
            return $attendance->status === 'Masuk';
        })->count();

        $pulang = $attendances->filter(function($attendance) {
            return $attendance->status === 'Pulang';
        })->count();

        $sakit = StudentAttendance::where('status', 'sakit')
                                ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
                                ->count();

        $izin = StudentAttendance::where('status', 'izin')
                                ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
                                ->count();

        $alpha = StudentAttendance::where('status', 'alpha')
                                ->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$selectedMonth])
                                ->count();

        $daysInMonth = \Carbon\Carbon::parse($selectedMonth)->daysInMonth;
        $tidak_hadir = $total_siswa * $daysInMonth - ($hadir + $masuk + $pulang + $sakit + $izin + $alpha);

        // Generate list of months for the dropdown
        $monthsList = [];
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths($i);
            $monthsList[$date->format('Y-m')] = $date->format('F Y');
        }

        return view('admin_tu.dashboard', compact('total_siswa', 'hadir', 'masuk', 'pulang', 'tidak_hadir', 'sakit', 'izin', 'alpha', 'selectedMonth', 'monthsList'));
    }

    private function determineStatus($waktu_masuk, $waktu_keluar, $information)
    {
        if ($information === 'sakit') {
            return 'Sakit';
        } elseif ($information === 'izin') {
            return 'Izin';
        } elseif ($information === 'alpha') {
            return 'alpha';
        } elseif ($waktu_masuk && $waktu_keluar) {
            return 'Hadir';
        } elseif ($waktu_masuk) {
            return 'Masuk';
        } elseif ($waktu_keluar) {
            return 'Pulang';
        } else {
            return 'Tanpa Keterangan';
        }
    }

    // public function kehadiran(Request $request)
    // {
    //     $query = Attendance::select('tag', 'date', 'status')
    //         ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
    //         ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
    //         ->groupBy('tag', 'date', 'status')
    //         ->with(['siswa' => function($query) {
    //             $query->select('id', 'nis', 'nama', 'uid_rfid', 'no_absen', 'jurusan', 'kelas', 'gambar');
    //         }]);

    //     // Apply filters based on request inputs
    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->whereHas('siswa', function ($q) use ($search) {
    //             $q->where('nis', 'like', "%{$search}%")
    //                 ->orWhere('nama', 'like', "%{$search}%")
    //                 ->orWhere('kelas', 'like', "%{$search}%");
    //         });
    //     }

    //     if ($request->has('kelas')) {
    //         $kelas = $request->input('kelas');
    //         $query->whereHas('siswa', function ($q) use ($kelas) {
    //             $q->where('kelas', $kelas);
    //         });
    //     }

    //     if ($request->has('date')) {
    //         $date = $request->input('date');
    //         $query->whereDate('date', $date);
    //     }

    //     $attendances = $query->get()->filter(function($attendance) {
    //         return $attendance->siswa !== null;
    //     });

    //     return view('admin_tu.kehadirantu', compact('attendances'));
    // }
    public function kehadiran(Request $request)
    {
        $query = Attendance::select('tag', 'date')
            ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
            ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
            ->selectRaw('MAX(CASE WHEN information = "in" THEN image_path END) AS image_masuk')
            ->selectRaw('MAX(CASE WHEN information = "out" THEN image_path END) AS image_keluar')
            ->groupBy('tag', 'date')
            ->with(['siswa' => function($query) {
                $query->select('id', 'nis', 'nama', 'uid_rfid', 'no_absen', 'jurusan', 'kelas');
            }]);

        // Apply filters
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', now()->toDateString());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nis', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%")
                ->orWhere('kelas', 'like', "%$search%");
            });
        }

        $setting = Setting::first();
        $in_start = Carbon::parse($setting->in_start)->format('H:i:s');

        $attendances = $query->get()
            ->filter(function($attendance) {
                return $attendance->siswa !== null;
            })
            ->map(function($attendance) use ($in_start) {
                $attendance->status = $this->determineStatuss($attendance->waktu_masuk, $attendance->waktu_keluar);
                $attendance->keterangan = $attendance->waktu_masuk && $attendance->waktu_masuk > $in_start ? 'Telat' : 'Tepat Waktu';
                return $attendance;
            });

        return view('admin_tu.kehadirantu', compact('attendances'));
    }
    
    private function determineStatuss($waktu_masuk, $waktu_keluar)
    {
        if ($waktu_masuk && $waktu_keluar) {
            return 'Hadir';
        } elseif ($waktu_masuk) {
            return 'Hadir';
        } elseif ($waktu_keluar) {
            return 'Pulang';
        } else {
            return 'Tidak Hadir';
        }
    }

    public function downloadPdf()
    {
        $siswas = Siswa::all(); // Ambil semua data siswa tanpa filter
        $pdf = PDF::loadView('admin_tu.kehadirantu_pdf', compact('siswas'));
        return $pdf->download('kehadiran.pdf');
    }

    public function downloadExcel(Request $request)
    {
        $query = Attendance::select('tag', 'date')
            ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
            ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
            ->groupBy('tag', 'date')
            ->with(['siswa' => function($query) {
                $query->select('id', 'nis', 'nama', 'uid_rfid', 'no_absen', 'jurusan', 'kelas');
            }]);

        // Apply filters
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nis', 'like', "%$search%")
                ->orWhere('nama', 'like', "%$search%")
                ->orWhere('kelas', 'like', "%$search%");
            });
        }

        $attendances = $query->get()
            ->filter(function($attendance) {
                return $attendance->siswa !== null;
            })
            ->map(function($attendance) {
                $attendance->status = $this->determineStatuss($attendance->waktu_masuk, $attendance->waktu_keluar);
                return $attendance;
            });

        if ($attendances->isEmpty()) {
            return back()->withErrors(['Mohon maaf, Anda tidak bisa mengunduh Excel karena data yang Anda cari tidak ada']);
        }

        return Excel::download(new KehadiranExport($attendances), 'kehadiran.xlsx');
    }
}
