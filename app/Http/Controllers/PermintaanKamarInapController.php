<?php

namespace App\Http\Controllers;

use App\Models\PermintaanKamarInap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermintaanKamarInapController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = PermintaanKamarInap::query();

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
            'petugas_pemohon' => 'required|uuid|exists:pegawai,id',
            'bed' => 'required|uuid|exists:bed,id',
            'diagnosa_awal' => 'nullable|string',
        ], [
            'required' => 'Form harus dilengkapi',
            'uuid' => 'Format tidak valid',
            'string' => 'Tipe data tidak valid',
            'exists' => 'Data yang di-rujuk tidak sesuai',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $permintaanKamar = PermintaanKamarInap::create([
                'no_rawat'=>$request->no_rawat,
                'petugas_pemohon'=>$request->petugas_pemohon,
                'bed'=>$request->bed,
                'diagnosa_awal'=>$request->diagnosa_awal,
                'waktu_permintaan'=>now(),
            ]);

            return response()->json([
                'message' => 'Permintaan Baru berhasil',
                'data' => $permintaanKamar
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }
}
