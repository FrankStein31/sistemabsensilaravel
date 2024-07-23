<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Excel;

class TuController extends Controller
{
    public function dashboard()
    {
        $total_siswa = Siswa::count();
        $hadir = Siswa::where('status', 'hadir')->count();
        $sakit = Siswa::where('status', 'sakit')->count();
        $izin = Siswa::where('status', 'izin')->count();
        $alpha = Siswa::where('status', 'alpha')->count();

        return view('admin_tu.dashboard', compact('total_siswa', 'hadir', 'sakit', 'izin', 'alpha'));
    }

    public function kehadiran(Request $request)
    {
        $kelas = $request->input('kelas');
        $bulan = $request->input('bulan');
        $search = $request->input('search');

        $query = Siswa::query();

        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        $siswas = $query->get();

        return view('admin_tu.kehadirantu', compact('siswas'));
    }

    public function downloadPdf(Request $request)
    {
        $siswas = $this->filterData($request);
        $pdf = PDF::loadView('admin_tu.kehadirantu_pdf', compact('siswas'));
        return $pdf->download('kehadiran.pdf');
    }

    public function downloadExcel(Request $request)
    {
        $siswas = $this->filterData($request);

        return Excel::create('kehadiran', function($excel) use ($siswas) {
            $excel->sheet('Sheet 1', function($sheet) use ($siswas) {
                $sheet->loadView('admin_tu.kehadirantu_excel', compact('siswas'));
            });
        })->download('xlsx');
    }

    private function filterData(Request $request)
    {
        $kelas = $request->input('kelas');
        $bulan = $request->input('bulan');
        $search = $request->input('search');

        $query = Siswa::query();

        if ($kelas) {
            $query->where('kelas', $kelas);
        }

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }
}
