<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Registrasi;
use App\Models\ResumeRalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeRalanController extends Controller
{
    public function show($id)
    {
        try {
            $resume = ResumeRalan::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$resume) {
                return response()->json(['message' => 'data not found'], 404);
            }

            return response()->json($resume);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $resume = ResumeRalan::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$resume) {
                return response()->json(['message' => 'data not found'], 404);
            }

            $resume->delete();

            return response()->json(['message' => 'data deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_rawat' => 'required|string|exists:registrasi,no_rawat',
            'dokter_dpjb' => 'required|uuid|exists:pegawai,id',
            'waktu_resume' => 'required|date_format:Y-m-d H:i:s|before_or_equal:now',
            'status_pulang' => 'required|in:HIDUP,MENINGGAL',
            'keluhan_utama' => 'nullable|string',
            'jalannya_penyakit_selama_perawatan' => 'nullable|string',
            'pemeriksaan_radiologi' => 'nullable|string',
            'pemeriksaan_laboratorium' => 'nullable|string',
            'riwayat_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
            'diagnosa_utama' => 'nullable|string',
            'diagnosa_sekunder' => 'nullable|string',
            'prosedur_utama' => 'nullable|string',
            'prosedur_sekunder' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Cek apakah pasien dengan no_rawat sudah ada di registrasi
            $pasien = Registrasi::where('no_rawat', $request->no_rawat)->first();

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data pasien tidak ditemukan'
                ], 404);
            }

            // Cek apakah pasien sudah membayar
            if ($pasien->status_bayar) {
                return response()->json([
                    'message' => 'Pasien telah membayar tagihan, resume tidak dapat dibuat atau diubah'
                ], 403);
            }

            // Cek apakah resume sudah ada
            $resume = ResumeRalan::where('no_rawat', $request->no_rawat)->first();

            if ($resume) {
                // Update jika resume sudah ada
                $resume->update($request->only([
                    'dokter_dpjb',
                    'waktu_resume',
                    'status_pulang',
                    'keluhan_utama',
                    'jalannya_penyakit_selama_perawatan',
                    'pemeriksaan_radiologi',
                    'pemeriksaan_laboratorium',
                    'riwayat_obat',
                    'catatan',
                    'diagnosa_utama',
                    'diagnosa_sekunder',
                    'prosedur_utama',
                    'prosedur_sekunder'
                ]));

                return response()->json([
                    'message' => 'Resume berhasil diperbarui',
                    'resume' => $resume
                ], 200);
            } else {
                // Buat resume baru jika belum ada
                $resume = ResumeRalan::create([
                    'no_rawat' => $request->no_rawat,
                    'dokter_dpjb' => $request->dokter_dpjb,
                    'waktu_resume' => $request->waktu_resume,
                    'status_pulang' => $request->status_pulang,
                    'keluhan_utama' => $request->keluhan_utama,
                    'jalannya_penyakit_selama_perawatan' => $request->jalannya_penyakit_selama_perawatan,
                    'pemeriksaan_radiologi' => $request->pemeriksaan_radiologi,
                    'pemeriksaan_laboratorium' => $request->pemeriksaan_laboratorium,
                    'riwayat_obat' => $request->riwayat_obat,
                    'catatan' => $request->catatan,
                    'diagnosa_utama' => $request->diagnosa_utama,
                    'diagnosa_sekunder' => $request->diagnosa_sekunder,
                    'prosedur_utama' => $request->prosedur_utama,
                    'prosedur_sekunder' => $request->prosedur_sekunder,
                ]);

                return response()->json([
                    'message' => 'Resume berhasil dibuat',
                    'resume' => $resume
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
