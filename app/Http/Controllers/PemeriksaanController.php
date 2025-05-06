<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'no_rawat' => 'required|exists:registrasi,no_rawat',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
        ], [
            'required' => 'Form harus dilengkapi',
            'exists' => 'Data no_rawat tidak ditemukan',
            'date' => 'Format tanggal tidak valid',
            'after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $data = $validate->validated();
            $tanggalMulai = isset($data['tanggal_mulai'])
                ? Carbon::parse($data['tanggal_mulai'])->startOfDay()
                : today()->startOfDay();

            $tanggalAkhir = isset($data['tanggal_akhir'])
                ? Carbon::parse($data['tanggal_akhir'])->endOfDay()
                : today()->endOfDay();

            $riwayatPemeriksaan = Pemeriksaan::where('no_rawat', $data['no_rawat'])
                ->whereBetween('btr.waktu_pemberian', [$tanggalMulai, $tanggalAkhir])
                ->join('pegawai', 'pemeriksaan.pegawai', '=', 'pegawai.id')
                ->get();

            if ($riwayatPemeriksaan->isEmpty()) {
                return response()->json([
                    'message' => "Riwayat tindakan untuk no_rawat {$data['no_rawat']} tidak ditemukan"
                ], 404);
            }

            return response()->json([
                'data' => $riwayatPemeriksaan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'lokasi_pemeriksaan' => 'required|in:RALAN,RANAP',
            'no_rawat' => 'required|exists:registrasi,no_rawat',
            'suhu_tubuh' => 'nullable|string|max:60',
            'tensi' => 'nullable|string|max:60',
            'nadi' => 'nullable|string|max:60',
            'respirasi' => 'nullable|string|max:60',
            'tinggi_badan' => 'nullable|string|max:60',
            'berat' => 'nullable|string|max:60',
            'spo2' => 'nullable|string|max:60',
            'gcs' => 'nullable|string|max:60',
            'kesadaran' => 'required|in:Compos Mentis,Somnolence,Sopor,Coma,Alert,Confusion,Voice,Pain,Unresponsive,Apatis,Delirium',
            'keluhan' => 'nullable|string',
            'pemeriksaan' => 'nullable|string',
            'alergi' => 'nullable|string',
            'lingkar_perut' => 'nullable|string|max:20',
            'rtl' => 'nullable|string',
            'penilaian' => 'nullable|string',
            'instruksi' => 'nullable|string',
            'evaluasi' => 'nullable|string',
            'waktu_pemeriksaan' => 'required|date_format:Y-m-d H:i:s|before_or_equal:now',
            'pegawai' => 'required|uuid|exists:pegawai,id',
        ], [
            'lokasi_pemeriksaan.required' => 'Lokasi pemeriksaan wajib diisi.',
            'lokasi_pemeriksaan.in' => 'Lokasi pemeriksaan harus bernilai RALAN atau RANAP.',
            'no_rawat.required' => 'Nomor rawat wajib diisi.',
            'no_rawat.exists' => 'Nomor rawat tidak ditemukan di dalam sistem.',
            'suhu_tubuh.max' => 'Panjang maksimum suhu tubuh adalah 60 karakter.',
            'tensi.max' => 'Panjang maksimum tensi adalah 60 karakter.',
            'nadi.max' => 'Panjang maksimum nadi adalah 60 karakter.',
            'respirasi.max' => 'Panjang maksimum respirasi adalah 60 karakter.',
            'tinggi_badan.max' => 'Panjang maksimum tinggi badan adalah 60 karakter.',
            'berat.max' => 'Panjang maksimum berat adalah 60 karakter.',
            'spo2.max' => 'Panjang maksimum SpO2 adalah 60 karakter.',
            'gcs.max' => 'Panjang maksimum GCS adalah 60 karakter.',
            'kesadaran.required' => 'Tingkat kesadaran wajib diisi.',
            'kesadaran.in' => 'Nilai kesadaran tidak valid.',
            'lingkar_perut.max' => 'Panjang maksimum lingkar perut adalah 20 karakter.',
            'waktu_pemeriksaan.required' => 'Waktu pemeriksaan wajib diisi.',
            'waktu_pemeriksaan.date_format' => 'Format waktu pemeriksaan harus Y-m-d H:i:s.',
            'waktu_pemeriksaan.before_or_equal' => 'Waktu pemeriksaan tidak boleh melebihi waktu sekarang.',
            'pegawai.required' => 'ID pegawai wajib diisi.',
            'pegawai.uuid' => 'Format ID pegawai harus UUID.',
            'pegawai.exists' => 'Pegawai tidak ditemukan dalam sistem.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan ke database dengan transaction
        DB::beginTransaction();
        try {
            $pemeriksaan = new Pemeriksaan();
            $pemeriksaan->id = Str::uuid();
            $pemeriksaan->lokasi_pemeriksaan = $request->lokasi_pemeriksaan;
            $pemeriksaan->no_rawat = $request->no_rawat;
            $pemeriksaan->suhu_tubuh = $request->suhu_tubuh;
            $pemeriksaan->tensi = $request->tensi;
            $pemeriksaan->nadi = $request->nadi;
            $pemeriksaan->respirasi = $request->respirasi;
            $pemeriksaan->tinggi_badan = $request->tinggi_badan;
            $pemeriksaan->berat = $request->berat;
            $pemeriksaan->spo2 = $request->spo2;
            $pemeriksaan->gcs = $request->gcs;
            $pemeriksaan->kesadaran = $request->kesadaran;
            $pemeriksaan->keluhan = $request->keluhan;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->alergi = $request->alergi;
            $pemeriksaan->lingkar_perut = $request->lingkar_perut;
            $pemeriksaan->rtl = $request->rtl;
            $pemeriksaan->penilaian = $request->penilaian;
            $pemeriksaan->instruksi = $request->instruksi;
            $pemeriksaan->evaluasi = $request->evaluasi;
            $pemeriksaan->waktu_pemeriksaan = $request->waktu_pemeriksaan;
            $pemeriksaan->pegawai = $request->pegawai;
            $pemeriksaan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pemeriksaan berhasil disimpan.',
                'data' => $pemeriksaan
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'suhu_tubuh' => 'nullable|string|max:60',
            'tensi' => 'nullable|string|max:60',
            'nadi' => 'nullable|string|max:60',
            'respirasi' => 'nullable|string|max:60',
            'tinggi_badan' => 'nullable|string|max:60',
            'berat' => 'nullable|string|max:60',
            'spo2' => 'nullable|string|max:60',
            'gcs' => 'nullable|string|max:60',
            'kesadaran' => 'required|in:Compos Mentis,Somnolence,Sopor,Coma,Alert,Confusion,Voice,Pain,Unresponsive,Apatis,Delirium',
            'keluhan' => 'nullable|string',
            'pemeriksaan' => 'nullable|string',
            'alergi' => 'nullable|string',
            'lingkar_perut' => 'nullable|string|max:20',
            'rtl' => 'nullable|string',
            'penilaian' => 'nullable|string',
            'instruksi' => 'nullable|string',
            'evaluasi' => 'nullable|string',
            'waktu_pemeriksaan' => 'required|date_format:Y-m-d H:i:s|before_or_equal:now',
            'pegawai' => 'required|uuid|exists:pegawai,id',
        ], [
            'suhu_tubuh.max' => 'Panjang maksimum suhu tubuh adalah 60 karakter.',
            'tensi.max' => 'Panjang maksimum tensi adalah 60 karakter.',
            'nadi.max' => 'Panjang maksimum nadi adalah 60 karakter.',
            'respirasi.max' => 'Panjang maksimum respirasi adalah 60 karakter.',
            'tinggi_badan.max' => 'Panjang maksimum tinggi badan adalah 60 karakter.',
            'berat.max' => 'Panjang maksimum berat adalah 60 karakter.',
            'spo2.max' => 'Panjang maksimum SpO2 adalah 60 karakter.',
            'gcs.max' => 'Panjang maksimum GCS adalah 60 karakter.',
            'kesadaran.required' => 'Tingkat kesadaran wajib diisi.',
            'kesadaran.in' => 'Nilai kesadaran tidak valid.',
            'lingkar_perut.max' => 'Panjang maksimum lingkar perut adalah 20 karakter.',
            'waktu_pemeriksaan.required' => 'Waktu pemeriksaan wajib diisi.',
            'waktu_pemeriksaan.date_format' => 'Format waktu pemeriksaan harus Y-m-d H:i:s.',
            'waktu_pemeriksaan.before_or_equal' => 'Waktu pemeriksaan tidak boleh melebihi waktu sekarang.',
            'pegawai.required' => 'ID pegawai wajib diisi.',
            'pegawai.uuid' => 'Format ID pegawai harus UUID.',
            'pegawai.exists' => 'Pegawai tidak ditemukan dalam sistem.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data dengan transaksi
        DB::beginTransaction();
        try {
            $pemeriksaan = Pemeriksaan::findOrFail($id);

            $pemeriksaan->suhu_tubuh = $request->suhu_tubuh;
            $pemeriksaan->tensi = $request->tensi;
            $pemeriksaan->nadi = $request->nadi;
            $pemeriksaan->respirasi = $request->respirasi;
            $pemeriksaan->tinggi_badan = $request->tinggi_badan;
            $pemeriksaan->berat = $request->berat;
            $pemeriksaan->spo2 = $request->spo2;
            $pemeriksaan->gcs = $request->gcs;
            $pemeriksaan->kesadaran = $request->kesadaran;
            $pemeriksaan->keluhan = $request->keluhan;
            $pemeriksaan->pemeriksaan = $request->pemeriksaan;
            $pemeriksaan->alergi = $request->alergi;
            $pemeriksaan->lingkar_perut = $request->lingkar_perut;
            $pemeriksaan->rtl = $request->rtl;
            $pemeriksaan->penilaian = $request->penilaian;
            $pemeriksaan->instruksi = $request->instruksi;
            $pemeriksaan->evaluasi = $request->evaluasi;
            $pemeriksaan->waktu_pemeriksaan = $request->waktu_pemeriksaan;
            $pemeriksaan->pegawai = $request->pegawai;
            $pemeriksaan->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pemeriksaan berhasil diperbarui.',
                'data' => $pemeriksaan
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data pemeriksaan tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pemeriksaan = Pemeriksaan::where('id', $id)
                ->firstOrFail();

            $pemeriksaan->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pemeriksaan berhasil dihapus.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data pemeriksaan tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
