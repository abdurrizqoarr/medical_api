<?php

use App\Http\Controllers\BahasaController;
use App\Http\Controllers\CacatFisikController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JaminanController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [UserController::class, 'userLogin']);
Route::get('/logout', [UserController::class, 'logout']);

route::get('/bahasa', [BahasaController::class, 'index']);
route::post('/bahasa', [BahasaController::class, 'store']);
route::put('/bahasa/{id}', [BahasaController::class, 'update']);
route::delete('/bahasa/{id}', [BahasaController::class, 'destroy']);
route::get('/bahasa-restore/{id}', [BahasaController::class, 'restore']);

route::get('/cacat-fisik', [CacatFisikController::class, 'index']);
route::post('/cacat-fisik', [CacatFisikController::class, 'store']);
route::put('/cacat-fisik/{id}', [CacatFisikController::class, 'update']);
route::delete('/cacat-fisik/{id}', [CacatFisikController::class, 'destroy']);
route::get('/cacat-fisik-restore/{id}', [CacatFisikController::class, 'restore']);

route::get('/dokter', [DokterController::class, 'index']);
route::post('/dokter', [DokterController::class, 'store']);
route::get('/dokter/{id}', [DokterController::class, 'show']);
route::put('/dokter/{id}', [DokterController::class, 'update']);
route::delete('/dokter/{id}', [DokterController::class, 'destroy']);

route::get('/jaminan', [JaminanController::class, 'index']);
route::post('/jaminan', [JaminanController::class, 'store']);
route::put('/jaminan/{id}', [JaminanController::class, 'update']);
route::delete('/jaminan/{id}', [JaminanController::class, 'destroy']);
route::get('/jaminan-restore/{id}', [JaminanController::class, 'restore']);

route::get('/kabupaten', [KabupatenController::class, 'index']);
route::post('/kabupaten', [KabupatenController::class, 'store']);
route::put('/kabupaten/{id}', [KabupatenController::class, 'update']);
route::delete('/kabupaten/{id}', [KabupatenController::class, 'destroy']);
route::get('/kabupaten-restore/{id}', [KabupatenController::class, 'restore']);

route::get('/kecamatan', [KecamatanController::class, 'index']);
route::post('/kecamatan', [KecamatanController::class, 'store']);
route::put('/kecamatan/{id}', [KecamatanController::class, 'update']);
route::delete('/kecamatan/{id}', [KecamatanController::class, 'destroy']);
route::get('/kecamatan-restore/{id}', [KecamatanController::class, 'restore']);

route::get('/keluarga', [KeluargaController::class, 'index']);
route::post('/keluarga', [KeluargaController::class, 'store']);
route::put('/keluarga/{id}', [KeluargaController::class, 'update']);
route::delete('/keluarga/{id}', [KeluargaController::class, 'destroy']);
route::get('/keluarga-restore/{id}', [KeluargaController::class, 'restore']);

route::get('/kelurahan', [KelurahanController::class, 'index']);
route::post('/kelurahan', [KelurahanController::class, 'store']);
route::put('/kelurahan/{id}', [KelurahanController::class, 'update']);
route::delete('/kelurahan/{id}', [KelurahanController::class, 'destroy']);
route::get('/kelurahan-restore/{id}', [KelurahanController::class, 'restore']);

route::get('/pasien', [PasienController::class, 'index']);
route::post('/pasien', [PasienController::class, 'store']);
route::get('/pasien/{id}', [PasienController::class, 'show']);
route::put('/pasien/{id}', [PasienController::class, 'update']);
route::delete('/pasien/{id}', [PasienController::class, 'destroy']);

route::get('/pegawai', [PegawaiController::class, 'index']);
route::post('/pegawai', [PegawaiController::class, 'store']);
route::get('/pegawai/{id}', [PegawaiController::class, 'show']);
route::put('/pegawai/{id}', [PegawaiController::class, 'update']);
route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy']);

route::get('/pendidikan', [PendidikanController::class, 'index']);
route::post('/pendidikan', [PendidikanController::class, 'store']);
route::put('/pendidikan/{id}', [PendidikanController::class, 'update']);
route::delete('/pendidikan/{id}', [PendidikanController::class, 'destroy']);
route::get('/pendidikan-restore/{id}', [PendidikanController::class, 'restore']);

route::get('/registrasi', [RegistrasiController::class, 'index']);
route::post('/registrasi', [RegistrasiController::class, 'store']);
route::get('/registrasi/{id}', [RegistrasiController::class, 'show']);
route::put('/registrasi/{id}', [RegistrasiController::class, 'update']);
route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy']);