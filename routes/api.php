<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ImageUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sensor-data', [SensorDataController::class, 'store']);
Route::post('/attendance-data', [AttendanceController::class, 'store']);
Route::post('/attendanceout-data', [AttendanceController::class, 'storeout']);
Route::post('/upload-image', [AttendanceController::class, 'uploadImage']);
// Route::post('/upload-image', [SiswaController::class, 'upload']);
// Route::post('/upload-image', [ImageUploadController::class, 'upload']);
