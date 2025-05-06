<?php

namespace App\Http\Controllers;

use App\Models\DpjbPasienRanap;
use App\Models\PermintaanKamarInap;
use App\Models\Registrasi;
use App\Models\RiwayatKamarPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'bed' => 'required|uuid|exists:bed,id',
            'diagnosa_awal' => 'nullable|string',
            'dpjb_ranap' => 'required|uuid|exists:dokter,id',
        ], [
            'no_rawat.required' => 'Nomor rawat wajib diisi.',
            'no_rawat.uuid' => 'Format nomor rawat tidak valid.',
            'no_rawat.exists' => 'Nomor rawat tidak ditemukan dalam data registrasi.',

            'bed.required' => 'Bed tujuan wajib diisi.',
            'bed.uuid' => 'Format ID bed tidak valid.',
            'bed.exists' => 'Data bed tidak ditemukan.',

            'dpjb_ranap.required' => 'Dokter wajib diisi.',
            'dpjb_ranap.uuid' => 'Format ID dokter tidak valid.',
            'dpjb_ranap.exists' => 'Data dokter tidak ditemukan.',

            'diagnosa_awal.string' => 'Diagnosa awal harus berupa teks.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $user = Auth::user();

            $permintaanKamar = PermintaanKamarInap::create([
                'no_rawat' => $request->no_rawat,
                'petugas_pemohon' => $user->pegawai_id,
                'bed_rencana' => $request->bed,
                'diagnosa_awal' => $request->diagnosa_awal,
                'dpjb_ranap' => $request->dpjb_ranap,
                'waktu_permintaan' => now(),
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

    public function pindahRanap(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'bed' => [
                'nullable',
                'uuid',
                'exists:bed,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status === 'DITERIMA' && !$value) {
                        $fail('Bed wajib diisi jika status diterima.');
                    }
                    if ($request->status === 'BATAL' && $value) {
                        $fail('Bed tidak boleh diisi jika status dibatalkan.');
                    }
                }
            ],
            'status' => 'required|in:PENDING,DITERIMA,BATAL',
        ], [
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status tidak valid.',
            'bed.uuid' => 'Format ID bed tidak valid.',
            'bed.exists' => 'Data bed tidak ditemukan.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $user = Auth::user();

            $permintaanKamar = PermintaanKamarInap::where('id', $id)
            ->join('bed', 'permintaan_kamar_inap.bed_rencana', '=', 'bed.id')
            ->firstOrFail();

            $permintaanKamar->petugas_penerima = $user->pegawai_id;
            $permintaanKamar->waktu_permintaan = now();
            $permintaanKamar->status = $request->status;

            // Atur bed_akhir sesuai status
            if ($request->status === 'DITERIMA') {
                $permintaanKamar->bed_akhir = $request->bed;
                $permintaanKamar->update();

                Registrasi::where('no_rawat', $permintaanKamar->no_rawat)->update([
                    "status_rawat" => "RANAP"
                ]);

                DpjbPasienRanap::create([
                    'no_rawat' => $permintaanKamar->no_rawat,
                    'dokter_dpjb' => $permintaanKamar->dpjb_ranap,
                    'dpjb_utama' => true
                ]);

                RiwayatKamarPasien::create([
                    'no_rawat'=> $permintaanKamar->no_rawat,
                    "bed" => $permintaanKamar->bed,
                    "tarif_per_malam" => $permintaanKamar->tarif,
                    "waktu_mulai"=>now(),
                    "lama_inap" => 1,
                    "tarif_total_inap" => $permintaanKamar->tarif,
                    "status"
                ]);
            } else {
                $permintaanKamar->bed_akhir = null;
                $permintaanKamar->update();
            }

            DB::commit();

            return response()->json([
                'message' => 'Permintaan kamar berhasil diperbarui.',
                'data' => $permintaanKamar
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }
}
