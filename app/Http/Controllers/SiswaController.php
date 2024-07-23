<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Attendance;
use App\Models\StudentAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SeventhSense\OpenCV\FaceRecognition;
use Pusher\Pusher;
use App\Models\Setting;
use Carbon\Carbon;

class SiswaController extends Controller
{
    // public function dashboard()
    // {
    //     $total_siswa = Siswa::count();
    //     $hadir = StudentAttendance::where('status', 'hadir')->count();
    //     $sakit = StudentAttendance::where('status', 'sakit')->count();
    //     $izin = StudentAttendance::where('status', 'izin')->count();
    //     $alpha = StudentAttendance::where('status', 'alpha')->count();

    //     return view('admin_sekolah.dashboard', compact('total_siswa', 'hadir', 'sakit', 'izin', 'alpha'));
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

        return view('admin_sekolah.dashboard', compact('total_siswa', 'hadir', 'masuk', 'pulang', 'tidak_hadir', 'sakit', 'izin', 'alpha', 'selectedMonth', 'monthsList'));
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

    public function index()
    {
        $siswas = Siswa::all();
        return view('admin_sekolah.manajemendatasiswa', compact('siswas'));
    }

    public function create()
    {
        return view('admin_sekolah.create_siswa');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas',
            'nama' => 'required',
            'no_absen' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'uid_rfid' => 'required|unique:siswas',
            'face_image' => 'required|image',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'unique' => ':attribute sudah terdaftar.',
        ]);

        // Store face image
        if ($request->hasFile('face_image')) {
            $faceImagePath = $request->file('face_image')->store('face_images', 'public');
        } else {
            $faceImagePath = null;
        }

        $siswa = new Siswa($request->all());
        $siswa->gambar = $faceImagePath;
        $siswa->save();

        return redirect()->route('admin_sekolah.manajemendatasiswa')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        return view('admin_sekolah.edit_siswa', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required',
            'no_absen' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'uid_rfid' => 'required|unique:siswas,uid_rfid,' . $siswa->id,
            'face_image' => 'sometimes|image',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'unique' => ':attribute sudah terdaftar.',
        ]);

        if ($request->hasFile('face_image')) {
            // Delete old image
            if ($siswa->gambar) {
                Storage::disk('public')->delete($siswa->gambar);
            }

            // Store new image
            $faceImagePath = $request->file('face_image')->store('face_images', 'public');
            $request->merge(['gambar' => $faceImagePath]);
        }

        $siswa->update($request->except(['gambar']));
        $siswa->gambar = $request->gambar;
        $siswa->save();

        return redirect()->route('admin_sekolah.manajemendatasiswa')->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->gambar) {
            Storage::disk('public')->delete($siswa->gambar);
        }

        $siswa->delete();
        return redirect()->route('admin_sekolah.manajemendatasiswa')->with('success', 'Data siswa berhasil dihapus');
    }

    // public function kehadiran()
    // {
    //     $attendances = Attendance::select('tag', 'date', 'status', 'image_path')
    //         ->selectRaw('MIN(CASE WHEN information = "in" THEN time END) AS waktu_masuk')
    //         ->selectRaw('MAX(CASE WHEN information = "out" THEN time END) AS waktu_keluar')
    //         ->groupBy('tag', 'date', 'status', 'image_path')
    //         ->with(['siswa' => function($query) {
    //             $query->select('id', 'nis', 'nama', 'uid_rfid', 'no_absen', 'jurusan', 'kelas');
    //         }])
    //         ->get()
    //         ->filter(function($attendance) {
    //             return $attendance->siswa !== null;
    //         });

    //     return view('admin_sekolah.kehadiran', compact('attendances'));
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

        return view('admin_sekolah.kehadiran', compact('attendances'));
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

    public function handlePresensi(Request $request)
    {
        $uid_rfid = $request->input('uid_rfid');
        $image = $request->file('image');

        $siswa = Siswa::where('uid_rfid', $uid_rfid)->first();
        if ($siswa) {
            // Store the captured image
            $imagePath = $image->store('attendance_images', 'public');

            // Perform face recognition using Seventh Sense API
            $faceRecognition = new FaceRecognition();
            $faceRecognition->setApiKey('8sYGwX_YTE1NWEwMTgtMGQzMy00MTg7LTk5YjctZWMyOGI5YzdlYzUx');
            $result = $faceRecognition->searchPersonByImage(Storage::disk('public')->path($imagePath));

            if ($result && $result['person_id'] === $siswa->id) {
                $siswa->update([
                    'status' => 'hadir',
                    'gambar' => $imagePath,
                ]);

                // Trigger Pusher event
                $pusher = new Pusher(
                    config('broadcasting.connections.pusher.key'),
                    config('broadcasting.connections.pusher.secret'),
                    config('broadcasting.connections.pusher.app_id'),
                    [
                        'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                        'useTLS' => true,
                    ]
                );

                $pusher->trigger('presensi-channel', 'presensi-event', [
                    'message' => 'Presensi berhasil untuk ' . $siswa->nama,
                ]);

                return response()->json(['message' => 'Presensi berhasil'], 200);
            } else {
                return response()->json(['message' => 'Wajah tidak cocok'], 400);
            }
        }

        return response()->json(['message' => 'Presensi gagal'], 400);
    }

    public function getRfidUid()
    {
        $latestTag = DB::table('adds')->latest('id')->value('tag');
        return response()->json(['uid_rfid' => $latestTag]);
    }

    public function getSiswaByNIS($nis)
    {
        $siswa = Siswa::where('nis', $nis)->first();
        return response()->json($siswa);
    }

    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the uploaded image
        if ($request->file('image')->isValid()) {
            $path = $request->file('image')->store('images', 'public');
            return response()->json(['url' => Storage::url($path)], 201);
        }

        return response()->json(['error' => 'Invalid image upload.'], 400);
    }
}
