<?php

namespace App\Http\Controllers;

use App\Models\Bed;
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
            $query = PermintaanKamarInap::query()
                ->select(
                    'permintaan_kamar_inap.diagnosa_awal',
                    'permintaan_kamar_inap.waktu_permintaan',
                    'permintaan_kamar_inap.waktu_terima',
                    'registrasi.pasien',
                    'registrasi.no_rawat',
                    'pasien.nama_pasien',
                    'pemohon.nama AS petugas_pemohon',
                    'penerima.nama AS petugas_penerima',
                    'bed_rencana.bed',
                    'bed_akhir.bed',
                    'pegawai_dokter.nama',
                    'status',
                );

            // Filter berdasarkan tanggal
            $tanggalMulai = $request->query('tanggal_mulai', today()->toDateString());
            $tanggalAkhir = $request->query('tanggal_akhir', today()->toDateString());

            $query->whereBetween('waktu_permintaan', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);

            $dataPermintaan = $query
                ->orderBy('waktu_permintaan')
                ->join('registrasi', 'registrasi.no_rawat', '=', 'permintaan_kamar_inap.no_rawat')
                ->join('pasien', 'pasien.no_rm', '=', 'registrasi.pasien')
                ->join('pegawai as pemohon', 'pemohon.id', '=', 'permintaan_kamar_inap.petugas_pemohon')
                ->leftJoin('pegawai as penerima', 'penerima.id', '=', 'permintaan_kamar_inap.petugas_penerima')
                ->join('bed as bed_rencana', 'bed_rencana.id', '=', 'permintaan_kamar_inap.bed_rencana')
                ->leftJoin('bed as bed_akhir', 'bed_akhir.id', '=', 'permintaan_kamar_inap.bed_akhir')
                ->join('dokter', 'dokter.id', '=', 'permintaan_kamar_inap.dpjb_ranap')
                ->join('pegawai as pegawai_dokter', 'pegawai_dokter.id', '=', 'dokter.pegawai')
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
            'no_rawat' => 'required|exists:registrasi,no_rawat',
            'bed' => 'required|uuid|exists:bed,id',
            'diagnosa_awal' => 'nullable|string',
            'dpjb_ranap' => 'required|uuid|exists:dokter,id',
        ], [
            'no_rawat.required' => 'Nomor rawat wajib diisi.',
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
            'status' => 'required|in:DITERIMA,BATAL',
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

            $permintaanKamar = PermintaanKamarInap::where('permintaan_kamar_inap.id', $id)
                ->firstOrFail();

            $permintaanKamar->petugas_penerima = $user->pegawai_id;
            $permintaanKamar->waktu_permintaan = now();
            $permintaanKamar->status = $request->status;

            // Atur bed_akhir sesuai status
            if ($request->status === 'DITERIMA') {
                $bed_data = Bed::where('id', $request->bed)->firstOrFail();

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
                    'no_rawat' => $permintaanKamar->no_rawat,
                    "bed" => $bed_data->bed,
                    "tarif_per_malam" => $bed_data->tarif,
                    "waktu_mulai" => now(),
                    "lama_inap" => 1,
                    "tarif_total_inap" => $bed_data->tarif,
                    "status"
                ]);
            } else {
                $permintaanKamar->bed_akhir = null;
                $permintaanKamar->save();
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
