<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPermintaanRadiologi;
use App\Models\PermintaanRadiologi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermintaanRadiologiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = PermintaanRadiologi::query();

            // Filter berdasarkan tanggal
            $tanggalMulai = $request->query('tanggal_mulai', today()->toDateString());
            $tanggalAkhir = $request->query('tanggal_akhir', today()->toDateString());

            $query->whereBetween('waktu_permintaan', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);

            $dataPermintaan = $query
                ->orderBy('waktu_permintaan')
                ->get();

            return response()->json([
                'data' => $dataPermintaan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'no_rawat' => 'required|uuid|exists:registrasi,no_rawat',
            'dokter_perujuk' => 'required|uuid|exists:pegawai,id',
            'informasi_tambahan' => 'nullable|string',
            'diganosis_klinis' => 'nullable|string',
            'detail_permintaan' => 'required|array',
            'detail_permintaan.*.id_jenis_tindakan_radiologi' => 'required|uuid|exists:jenis_tindakan_radiologi,id'
        ], [
            'required' => 'Form harus dilengkapi',
            'uuid' => 'Format tidak valid',
            'string' => 'Tipe data tidak valid',
            'exists' => 'Data yang di-rujuk tidak sesuai',
            'array' => 'Format detail permintaan tidak valid',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $permintaanRadiologi = PermintaanRadiologi::create([
                'no_rawat' => $request->no_rawat,
                'dokter_perujuk' => $request->dokter_perujuk,
                'waktu_permintaan' => now(),
                'informasi_tambahan' => $request->informasi_tambahan,
                'diganosis_klinis' => $request->diganosis_klinis,
            ]);

            // Simpan detail permintaan radiologi
            $detailPermintaanData = [];
            foreach ($request->detail_permintaan as $detail) {
                $detailPermintaanData[] = [
                    'id' => Str::uuid(),
                    'id_permintaan_radiologi' => $permintaanRadiologi->id,
                    'id_jenis_tindakan_radiologi' => $detail['id_jenis_tindakan_radiologi'],
                    'status' => 'BELUM',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DetailPermintaanRadiologi::insert($detailPermintaanData);

            DB::commit();

            return response()->json([
                'message' => 'Permintaan Baru berhasil dibuat',
                'data' => $permintaanRadiologi
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    public function updateWaktuSampel($id)
    {
        try {
            $dataPermintaan = PermintaanRadiologi::where('id', $id)->first();

            if (!$dataPermintaan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dataPermintaan->update([
                'waktu_sampel' => now()
            ]);

            return response()->json([
                'message' => 'waktu pengambilan sample di perbarui',
                'data' => $dataPermintaan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dataPermintaan = PermintaanRadiologi::find($id);

            if (!$dataPermintaan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dataPermintaan->delete();
            return response()->json(['message' => 'data permintaan deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $permintaan = PermintaanRadiologi::with(['detailPermintaan.jenisTindakanRadiologi', 'registrasi', 'dokterPerujuk'])
                ->where('id', $id)
                ->first();
    
            if (!$permintaan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
    
            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $permintaan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }
}
