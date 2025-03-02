<?php

use App\Http\Controllers\BahasaController;
use App\Http\Controllers\BangsalController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\CacatFisikController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\DepoController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JaminanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\JenisTindakanLabController;
use App\Http\Controllers\JenisTindakanRadiologiController;
use App\Http\Controllers\JenisTindakanRalanController;
use App\Http\Controllers\JenisTindakanRanapController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PenerimaanBarangMedisController;
use App\Http\Controllers\PengajuanBarangMedisController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SpesialisController;
use App\Http\Controllers\SukuController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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

route::get('/provinsi', [ProvinsiController::class, 'index']);
route::post('/provinsi', [ProvinsiController::class, 'store']);
route::put('/provinsi/{id}', [ProvinsiController::class, 'update']);
route::delete('/provinsi/{id}', [ProvinsiController::class, 'destroy']);
route::get('/provinsi-restore/{id}', [ProvinsiController::class, 'restore']);

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

route::get('/bangsal', [BangsalController::class, 'index']);
route::post('/bangsal', [BangsalController::class, 'store']);
route::put('/bangsal/{id}', [BangsalController::class, 'update']);
route::delete('/bangsal/{id}', [BangsalController::class, 'destroy']);
route::get('/bangsal-restore/{id}', [BangsalController::class, 'restore']);

route::get('/bed', [BedController::class, 'index']);
route::post('/bed', [BedController::class, 'store']);
route::put('/bed/{id}', [BedController::class, 'update']);
route::delete('/bed/{id}', [BedController::class, 'destroy']);
route::get('/bed-restore/{id}', [BedController::class, 'restore']);

route::get('/depo', [DepoController::class, 'index']);
route::post('/depo', [DepoController::class, 'store']);
route::put('/depo/{id}', [DepoController::class, 'update']);
route::delete('/depo/{id}', [DepoController::class, 'destroy']);
route::get('/depo-restore/{id}', [DepoController::class, 'restore']);

route::get('/golongan', [GolonganController::class, 'index']);
route::post('/golongan', [GolonganController::class, 'store']);
route::put('/golongan/{id}', [GolonganController::class, 'update']);
route::delete('/golongan/{id}', [GolonganController::class, 'destroy']);
route::get('/golongan-restore/{id}', [GolonganController::class, 'restore']);

route::get('/jenis', [JenisController::class, 'index']);
route::post('/jenis', [JenisController::class, 'store']);
route::put('/jenis/{id}', [JenisController::class, 'update']);
route::delete('/jenis/{id}', [JenisController::class, 'destroy']);
route::get('/jenis-restore/{id}', [JenisController::class, 'restore']);

route::get('/kategori', [KategoriController::class, 'index']);
route::post('/kategori', [KategoriController::class, 'store']);
route::put('/kategori/{id}', [KategoriController::class, 'update']);
route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
route::get('/kategori-restore/{id}', [KategoriController::class, 'restore']);

route::get('/satuan', [SatuanController::class, 'index']);
route::post('/satuan', [SatuanController::class, 'store']);
route::put('/satuan/{id}', [SatuanController::class, 'update']);
route::delete('/satuan/{id}', [SatuanController::class, 'destroy']);
route::get('/satuan-restore/{id}', [SatuanController::class, 'restore']);

route::get('/supplier', [SupplierController::class, 'index']);
route::post('/supplier', [SupplierController::class, 'store']);
route::put('/supplier/{id}', [SupplierController::class, 'update']);
route::delete('/supplier/{id}', [SupplierController::class, 'destroy']);
route::get('/supplier-restore/{id}', [SupplierController::class, 'restore']);

route::get('/pasien', [PasienController::class, 'index']);
route::post('/pasien', [PasienController::class, 'store']);
route::get('/pasien/{id}', [PasienController::class, 'show']);
route::put('/pasien/{id}', [PasienController::class, 'update']);
route::delete('/pasien/{id}', [PasienController::class, 'destroy']);

route::get('/pegawai', [PegawaiController::class, 'index']);
route::get('/pegawai-simple', [PegawaiController::class, 'getSimplePegawai']);
route::post('/pegawai', [PegawaiController::class, 'store']);
route::get('/pegawai/{id}', [PegawaiController::class, 'show']);
route::put('/pegawai/{id}', [PegawaiController::class, 'update']);
route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy']);

route::get('/pendidikan', [PendidikanController::class, 'index']);
route::post('/pendidikan', [PendidikanController::class, 'store']);
route::put('/pendidikan/{id}', [PendidikanController::class, 'update']);
route::delete('/pendidikan/{id}', [PendidikanController::class, 'destroy']);
route::get('/pendidikan-restore/{id}', [PendidikanController::class, 'restore']);

route::get('/data-barang', [DataBarangController::class, 'index']);
route::post('/data-barang', [DataBarangController::class, 'store']);
route::put('/data-barang/{id}', [DataBarangController::class, 'update']);
route::delete('/data-barang/{id}', [DataBarangController::class, 'destroy']);
route::delete('/data-barang-trashed/{id}', [DataBarangController::class, 'trashed']);
route::get('/data-barang-restore/{id}', [DataBarangController::class, 'restore']);

route::post('/pengajuan-barang', [PengajuanBarangMedisController::class, 'createPengajuan']);
route::put('/pengajuan-barang/{id}', [PengajuanBarangMedisController::class, 'updatePengajuan']);
route::put('/pengajuan-barang-update-status/{id}', [PengajuanBarangMedisController::class, 'updateStatusPengajuan']);
route::post('/penerimaan-barang/{id}', [PenerimaanBarangMedisController::class, 'terimaBarang']);

route::get('/poli', [PoliController::class, 'index']);
route::post('/poli', [PoliController::class, 'store']);
route::put('/poli/{id}', [PoliController::class, 'update']);
route::delete('/poli/{id}', [PoliController::class, 'destroy']);
route::get('/poli-restore/{id}', [PoliController::class, 'restore']);

route::get('/registrasi', [RegistrasiController::class, 'index']);
route::post('/registrasi', [RegistrasiController::class, 'store']);
route::get('/registrasi/{id}', [RegistrasiController::class, 'show']);
route::put('/registrasi/{id}', [RegistrasiController::class, 'update']);
route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy']);

route::get('/spesialis', [SpesialisController::class, 'index']);
route::post('/spesialis', [SpesialisController::class, 'store']);
route::put('/spesialis/{id}', [SpesialisController::class, 'update']);
route::delete('/spesialis/{id}', [SpesialisController::class, 'destroy']);
route::get('/spesialis-restore/{id}', [SpesialisController::class, 'restore']);

route::get('/suku', [SukuController::class, 'index']);
route::post('/suku', [SukuController::class, 'store']);
route::put('/suku/{id}', [SukuController::class, 'update']);
route::delete('/suku/{id}', [SukuController::class, 'destroy']);
route::get('/suku-restore/{id}', [SukuController::class, 'restore']);

route::get('/jenis-tindakan-ralan', [JenisTindakanRalanController::class, 'index']);
route::post('/jenis-tindakan-ralan', [JenisTindakanRalanController::class, 'store']);
route::put('/jenis-tindakan-ralan/{id}', [JenisTindakanRalanController::class, 'update']);
route::delete('/jenis-tindakan-ralan/{id}', [JenisTindakanRalanController::class, 'destroy']);
route::get('/jenis-tindakan-ralan-restore/{id}', [JenisTindakanRalanController::class, 'restore']);

route::get('/jenis-tindakan-ranap', [JenisTindakanRanapController::class, 'index']);
route::post('/jenis-tindakan-ranap', [JenisTindakanRanapController::class, 'store']);
route::put('/jenis-tindakan-ranap/{id}', [JenisTindakanRanapController::class, 'update']);
route::delete('/jenis-tindakan-ranap/{id}', [JenisTindakanRanapController::class, 'destroy']);
route::get('/jenis-tindakan-ranap-restore/{id}', [JenisTindakanRanapController::class, 'restore']);

route::get('/jenis-tindakan-lab', [JenisTindakanLabController::class, 'index']);
route::post('/jenis-tindakan-lab', [JenisTindakanLabController::class, 'store']);
route::put('/jenis-tindakan-lab/{id}', [JenisTindakanLabController::class, 'update']);
route::delete('/jenis-tindakan-lab/{id}', [JenisTindakanLabController::class, 'destroy']);
route::get('/jenis-tindakan-lab-restore/{id}', [JenisTindakanLabController::class, 'restore']);

route::get('/jenis-tindakan-radiologi', [JenisTindakanRadiologiController::class, 'index']);
route::post('/jenis-tindakan-radiologi', [JenisTindakanRadiologiController::class, 'store']);
route::put('/jenis-tindakan-radiologi/{id}', [JenisTindakanRadiologiController::class, 'update']);
route::delete('/jenis-tindakan-radiologi/{id}', [JenisTindakanRadiologiController::class, 'destroy']);
route::get('/jenis-tindakan-radiologi-restore/{id}', [JenisTindakanRadiologiController::class, 'restore']);
