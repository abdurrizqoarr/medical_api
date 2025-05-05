<?php

namespace App\Http\Controllers;

use App\Models\BeriTindakanRalan as ModelsBeriTindakanRalan;
use App\Models\Dokter;
use App\Models\JenisTindakanRalan;
use App\Models\Registrasi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BeriTindakanRalanController extends Controller
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

            $riwayatTindakan = DB::table('beri_tindakan_ralan as btr')
                ->join('pegawai as d', 'btr.dokter', '=', 'd.id')   // join untuk dokter
                ->join('pegawai as p', 'btr.perawat', '=', 'p.id')  // join untuk perawat
                ->where('btr.no_rawat', $data['no_rawat'])
                ->whereBetween('btr.waktu_pemberian', [$tanggalMulai, $tanggalAkhir])
                ->orderBy('btr.waktu_pemberian', 'desc')
                ->select([
                    'btr.id',
                    'btr.no_rawat',
                    'btr.nama_perawatan',
                    'btr.total_tarif',
                    'btr.waktu_pemberian',
                    'd.nama as nama_dokter',
                    'p.nama as nama_perawat',
                ])
                ->get();

            if ($riwayatTindakan->isEmpty()) {
                return response()->json([
                    'message' => "Riwayat tindakan untuk no_rawat {$data['no_rawat']} tidak ditemukan"
                ], 404);
            }

            return response()->json(['data' => $riwayatTindakan], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    public function beriTindakan(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'no_rawat' => 'required|exists:registrasi,no_rawat',
            'dokter' => 'required|uuid|exists:dokter,id',
            'perawat' => 'required|uuid|exists:pegawai,id',
            'id_tindakan' => 'required|array',
            'id_tindakan.*' => 'required|uuid|exists:jenis_tindakan_ralan,id',
            'waktu_pemberian' => 'required|date_format:Y-m-d H:i:s|before_or_equal:now'
        ], [
            'no_rawat.required' => 'Nomor rawat wajib diisi.',
            'no_rawat.uuid' => 'Format nomor rawat tidak valid.',
            'no_rawat.exists' => 'Nomor rawat tidak ditemukan di database.',

            'dokter.required' => 'ID dokter wajib diisi.',
            'dokter.uuid' => 'Format ID dokter tidak valid.',
            'dokter.exists' => 'Data dokter tidak ditemukan.',

            'perawat.required' => 'ID perawat wajib diisi.',
            'perawat.uuid' => 'Format ID perawat tidak valid.',
            'perawat.exists' => 'Data perawat tidak ditemukan.',

            'id_tindakan.required' => 'Daftar tindakan wajib diisi.',
            'id_tindakan.array' => 'Format daftar tindakan tidak valid.',

            'id_tindakan.*.required' => 'Setiap ID tindakan harus diisi.',
            'id_tindakan.*.uuid' => 'Format salah satu ID tindakan tidak valid.',
            'id_tindakan.*.exists' => 'Salah satu ID tindakan tidak ditemukan di database.',

            'waktu_pemberian.required' => 'Waktu pemberian wajib diisi.',
            'waktu_pemberian.date_format' => 'Format waktu pemberian harus Y-m-d H:i:s.',
            'waktu_pemberian.before_or_equal' => 'Waktu pemberian tidak boleh di masa depan.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $pasien = Registrasi::where('no_rawat', $request->no_rawat)->first();

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            if ($pasien->status_bayar) {
                return response()->json([
                    'message' => 'Pasien telah membayar tagihan, data tidak dapat diubah'
                ], 403);
            }

            $tindakanList = JenisTindakanRalan::whereIn('id', $request->id_tindakan)->get()->keyBy('id');
            $dataPegawaiDokter = Dokter::select('pegawai')->where('id', $request->dokter)->first();

            if (!$dataPegawaiDokter) {
                return response()->json([
                    'message' => 'Data dokter tidak ditemukan'
                ], 400);
            }

            if ($tindakanList->count() !== count($request->id_tindakan)) {
                return response()->json([
                    'message' => 'Beberapa tindakan tidak valid'
                ], 400);
            }

            $insertData = [];
            foreach ($request->id_tindakan as $idTindakan) {
                $tindakan = $tindakanList[$idTindakan];

                $insertData[] = [
                    'id' => Str::uuid(),
                    'no_rawat' => $request->no_rawat,
                    'dokter' => $dataPegawaiDokter->pegawai,
                    'perawat' => $request->perawat,
                    'nama_perawatan' => $tindakan->nama_perawatan,
                    'total_tarif' => $tindakan->total_tarif,
                    'bhp' => $tindakan->bhp,
                    'kso' => $tindakan->kso,
                    'manajemen' => $tindakan->manajemen,
                    'material' => $tindakan->material,
                    'tarif_dokter' => $tindakan->tarif_dokter,
                    'tarif_perawat' => $tindakan->tarif_perawat,
                    'waktu_pemberian' => $request->waktu_pemberian,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($insertData)) {
                ModelsBeriTindakanRalan::insert($insertData);
            } else {
                return response()->json([
                    'message' => 'Tidak ada data yang dimasukkan'
                ], 400);
            }

            DB::commit();
            return response()->json([
                'message' => 'Data Beri Tindakan Ralan berhasil dibuat',
                'data' => null
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request,)
    {
        $validate = Validator::make($request->all(), [
            'no_rawat' => 'required|exists:registrasi,no_rawat',
            'id' => 'required|array',
            'id.*' => 'required|uuid|exists:beri_tindakan_ralan,id',
        ], [
            'required' => 'Form harus dilengkapi',
            'array' => 'Data yang dikirim harus berupa array',
            'uuid' => 'Format ID tidak valid',
            'no_rawat.exists' => 'Registrasi tidak ditemukan',
            'id.*.exists' => 'Salah satu tindakan tidak ditemukan dalam database',
            'id.*.uuid' => 'Salah satu ID tindakan memiliki format UUID yang tidak valid',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $pasien = Registrasi::where('no_rawat', $request->no_rawat)->first();

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            if ($pasien->status_bayar) {
                return response()->json([
                    'message' => 'Pasien telah membayar tagihan, data tidak dapat diubah'
                ], 403);
            }

            // Verifikasi bahwa semua id tindakan memang milik no_rawat yang sama
            $invalidIds = ModelsBeriTindakanRalan::whereIn('id', $request->id)
                ->where('no_rawat', '!=', $request->no_rawat)
                ->pluck('id');

            if ($invalidIds->isNotEmpty()) {
                return response()->json([
                    'message' => 'Beberapa tindakan berasal dari data pasien lain.',
                    'invalid_ids' => $invalidIds
                ], 422);
            }

            // Hapus semua data
            ModelsBeriTindakanRalan::whereIn('id', $request->id)->delete();

            return response()->json([
                'message' => 'tindakan berhasil dihapus',
                'deleted_ids' => $request->id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
