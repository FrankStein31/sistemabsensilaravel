<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Add;
use App\Models\Adds;
use App\Models\Siswa;
use App\Models\User;

class SensorDataController extends Controller
{
    public function store(Request $request)
    {
        // Validasi request
        $validatedData = $request->validate([
            'tag' => 'required',
        ]);

        $existingData = Add::where('tag', $validatedData['tag'])->first();

        if ($existingData) {
            $existingData->delete();
        }


        $user = Siswa::where('uid_rfid', $validatedData['tag'])->first();

        if ($user) {
            return response()->json(['error' => 'Tag sudah digunakan'], 400);
        }

        $add = new Add;
        $add->tag = $validatedData['tag'];
        $add->save();

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }
}
