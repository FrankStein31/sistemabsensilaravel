<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $attendances = StudentAttendance::with('siswa')->get();
        return view('admin_sekolah.student_attendances.index', compact('attendances'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        return view('admin_sekolah.student_attendances.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:alpha,izin,sakit',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $attendance = new StudentAttendance($validated);
        if ($request->hasFile('gambar')) {
            $attendance->gambar = $request->file('gambar')->store('images', 'public');
        }
        $attendance->save();

        return redirect()->route('student_attendances.index')->with('success', 'Data presensi berhasil ditambahkan.');
    }
}
