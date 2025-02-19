<?php

namespace App\Http\Controllers;

use App\Models\BeriTindakanRalan as ModelsBeriTindakanRalan;
use App\Models\JenisTindakanRalan;
use App\Models\Registrasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeriTindakanRalanController extends Controller
{
    public function index(Request $request, $id)
    {
        // Validasi tanggal
        $validate = Validator::make($request->query(), [
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            // Cek apakah no_rawat ada
            $registrasiPasien = Registrasi::where('no_rawat', $id)->first();

            if (!$registrasiPasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $riwayatTindakan = ModelsBeriTindakanRalan::where('no_rawat', $id);

            // Ambil tanggal mulai dan akhir, jika tidak ada ambil default hari ini
            $tanggalMulai = Carbon::parse($request->query('tanggal_mulai', today()))->startOfDay();
            $tanggalAkhir = Carbon::parse($request->query('tanggal_akhir', today()))->endOfDay();

            // Terapkan filter tanggal
            $riwayatTindakan->whereBetween('waktu_pemberian', [$tanggalMulai, $tanggalAkhir]);

            // Ambil data riwayat tindakan
            $riwayatTindakan = $riwayatTindakan->get();

            if ($riwayatTindakan->isEmpty()) {
                return response()->json([
                    'message' => 'Riwayat tindakan tidak ditemukan'
                ], 404);
            }

            return response()->json(['data' => $riwayatTindakan], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    public function beriTindakan(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'no_rawat' => 'required|uuid|exists:registrasi,no_rawat',
            'dokter' => 'required|uuid|exists:pegawai,id',
            'perawat' => 'required|uuid|exists:pegawai,id',
            'id_tindakan' => 'required|array',
            'id_tindakan.*' => 'required|uuid|exists:jenis_tindakan_ralan,id'
        ], [
            'required' => 'Form harus dilengkapi',
            'arra' => 'Form data tidak valid',
            'uuid' => 'Format tidak valid',
            'exists' => 'Data yang di-rujuk tidak sesuai',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $tindakanList = [];

            foreach ($request->id_tindakan as $idTindakan) {
                $tindakan = JenisTindakanRalan::find($idTindakan);

                if (!$tindakan) {
                    continue; // Skip jika tidak ditemukan (seharusnya tidak terjadi karena ada validasi exists)
                }

                $beriTindakan = ModelsBeriTindakanRalan::create([
                    'no_rawat' => $request->no_rawat,
                    'dokter' => $request->dokter,
                    'perawat' => $request->perawat,
                    'nama_perawatan' => $tindakan->nama_perawatan,
                    'total_tarif' => $tindakan->total_tarif,
                    'bhp' => $tindakan->bhp,
                    'kso' => $tindakan->kso,
                    'manajemen' => $tindakan->manajemen,
                    'material' => $tindakan->material,
                    'tarif_dokter' => $tindakan->tarif_dokter,
                    'tarif_perawat' => $tindakan->tarif_perawat,
                    'waktu_pemberian' => now(),
                ]);

                $tindakanList[] = $beriTindakan;
            }

            return response()->json([
                'message' => 'Data Beri Tindakan Ralan berhasil dibuat',
                'data' => $tindakanList
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|array',
            'id.*' => 'required|uuid|exists:beri_tindakan_ralan,id'
        ], [
            'required' => 'Form harus dilengkapi',
            'array' => 'Data yang dikirim harus berupa array',
            'uuid' => 'Format ID tidak valid',
            'exists' => 'Salah satu ID tidak ditemukan dalam database',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            // Ambil semua data yang sesuai dengan ID yang dikirim
            $data = ModelsBeriTindakanRalan::whereIn('id', $request->id)->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Hapus semua data
            ModelsBeriTindakanRalan::whereIn('id', $request->id)->delete();

            return response()->json([
                'message' => 'Beri tindakan berhasil dihapus',
                'deleted_ids' => $request->id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
