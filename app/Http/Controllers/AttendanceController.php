<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'required',
            'information' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'image_path' => 'nullable|string'
        ]);

        $user = Siswa::where('uid_rfid', $request->tag)->first();

        if (!$user) {
            return response()->json(['error' => 'Tag Tidak Terdaftar'], 400);
        }

        $existingAttendance = Attendance::where('tag', $request->tag)
            ->where('information', $request->information)
            ->where('date', $request->date)
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'Data sudah ada untuk tanggal ini'], 409);
        }

        $setting = Setting::first();
        $requestTime = Carbon::createFromFormat('H:i:s', $request->time)->format('H:i:s');
        $inStart = Carbon::createFromFormat('H:i:s', $setting->in_start)->format('H:i:s');
        $inEnd = Carbon::createFromFormat('H:i:s', $setting->in_end)->format('H:i:s');

        if ($requestTime >= $inStart && $requestTime <= $inEnd) {
            $status = 'Masuk';
            $statusCode = 200;
        } else {
            $status = 'Telat';
            $statusCode = 201;
        }

        // Jika image_path tidak ada dalam request, ambil gambar terakhir dari storage/public/images
        if (!$request->has('image_path') || empty($request->image_path)) {
            $files = Storage::disk('public')->files('public/images');
            usort($files, function ($a, $b) {
                return Storage::disk('public')->lastModified($b) - Storage::disk('public')->lastModified($a);
            });

            $latestImage = !empty($files) ? $files[0] : null;
            Log::info('Latest Image: ' . $latestImage);
            $imagePath = $latestImage ? 'storage/public/images/' . basename($latestImage) : null;
            Log::info('Image Path: ' . $imagePath);
        } else {
            $imagePath = $request->image_path;
        }

        $attendance = Attendance::create([
            'tag' => $request->tag,
            'information' => $request->information,
            'date' => $request->date,
            'time' => $request->time,
            'status' => $status,
            'image_path' => $imagePath
        ]);

        Log::info('Attendance Created: ' . json_encode($attendance));

        return response()->json(['message' => 'Data berhasil disimpan', 'image_path' => $imagePath], $statusCode);
    }

    // Fungsi untuk menyimpan data absensi keluar
    public function storeout(Request $request)
    {
        $request->validate([
            'tag' => 'required',
            'information' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'image_path' => 'nullable|string'
        ]);

        $user = Siswa::where('uid_rfid', $request->tag)->first();

        if (!$user) {
            return response()->json(['error' => 'Tag Tidak Terdaftar'], 400);
        }

        $existingAttendance = Attendance::where('tag', $request->tag)
            ->where('information', $request->information)
            ->where('date', $request->date)
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'Data sudah ada untuk tanggal ini'], 409);
        }

        $setting = Setting::first();
        $requestTime = Carbon::createFromFormat('H:i:s', $request->time)->format('H:i:s');
        $outStart = Carbon::createFromFormat('H:i:s', $setting->out_start)->format('H:i:s');

        if ($requestTime >= $outStart) {
            $status = 'Keluar';

            // Jika image_path tidak ada dalam request, ambil gambar terakhir dari storage/public/images
            if (!$request->has('image_path') || empty($request->image_path)) {
                $files = Storage::disk('public')->files('public/images');
                usort($files, function ($a, $b) {
                    return Storage::disk('public')->lastModified($b) - Storage::disk('public')->lastModified($a);
                });

                $latestImage = !empty($files) ? $files[0] : null;
                Log::info('Latest Image (out): ' . $latestImage);
                $imagePath = $latestImage ? 'storage/public/images/' . basename($latestImage) : null;
                Log::info('Image Path (out): ' . $imagePath);
            } else {
                $imagePath = $request->image_path;
            }

            $attendance = Attendance::create([
                'tag' => $request->tag,
                'information' => $request->information,
                'date' => $request->date,
                'time' => $request->time,
                'status' => $status,
                'image_path' => $imagePath
            ]);

            Log::info('Attendance Out Created: ' . json_encode($attendance));

            return response()->json(['message' => 'Data berhasil disimpan', 'image_path' => $imagePath], 200);
        } else if ($requestTime <= $outStart) {
            return response()->json(['message' => 'Belum Waktu Pulang'], 201);
        }
    }


    public function uploadImage(Request $request)
    {
        Log::info('Received upload request');

        // Pastikan request memiliki file
        if (!$request->getContent()) {
            Log::error('No file content found in request');
            return response()->json(['error' => 'No file found'], 400);
        }

        // Ambil data binary dari body request
        $fileContent = $request->getContent();
        $timestamp = now()->format('Ymd_His');
        $filename = "image_{$timestamp}.jpg";
        $path = "public/images/{$filename}";

        try {
            // Simpan file ke storage dengan path 'public/images'
            Storage::disk('public')->put($path, $fileContent);
            Log::info('File uploaded successfully', ['filename' => $filename]);

            // Mengembalikan URL penuh ke gambar yang disimpan
            $url = Storage::url($path);

            return response()->json(['message' => 'File uploaded successfully', 'image_path' => $url], 200);
        } catch (\Exception $e) {
            Log::error('Failed to upload file', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to upload file', 'message' => $e->getMessage()], 500);
        }
    }
}
