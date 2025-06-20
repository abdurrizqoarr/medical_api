<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Registrasi::query();

            // Filter berdasarkan tanggal
            $tanggalMulai = $request->query('tanggal_mulai', today()->toDateString());
            $tanggalAkhir = $request->query('tanggal_akhir', today()->toDateString());

            $query->whereBetween('waktu_registrasi', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);

            // Filter berdasarkan status_periksa, jaminan, status_bayar, poli, dokter
            if ($request->filled('status_periksa')) {
                $query->where('status_periksa', $request->status_periksa);
            }
            if ($request->filled('jaminan')) {
                $query->where('jaminan', $request->jaminan);
            }
            if ($request->filled('status_bayar')) {
                $query->where('status_bayar', $request->status_bayar);
            }
            if ($request->filled('poli')) {
                $query->where('poli', $request->poli);
            }
            if ($request->filled('dokter')) {
                $query->where('dokter', $request->dokter);
            }

            // Filter berdasarkan no_rm, nama_pasien, no_ktp di tabel pasien
            if ($request->filled('cari')) {
                $cari = $request->cari;
                $query->whereHas('pasienData', function ($q) use ($cari) {
                    $q->where('no_rm', 'LIKE', "%$cari%")
                        ->orWhere('nama_pasien', 'LIKE', "%$cari%")
                        ->orWhere('no_ktp', 'LIKE', "%$cari%");
                });
            }

            $sortBy = $request->query('sort_by', 'waktu_registrasi');
            $sortOrder = $request->query('sort_order', 'asc');

            if (!in_array($sortBy, ['waktu_registrasi'])) {
                $sortBy = 'waktu_registrasi';
            }

            $query->orderBy($sortBy, $sortOrder);

            // Ambil data
            $registrasi = $query->with('pasienData')
                ->with('poliData')
                ->with('dokterData')
                ->with('jaminanData')
                ->get();

            return response()->json([
                'data' => $registrasi
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function pasienRalan(Request $request)
    {
        try {
            $query = Registrasi::query();

            // Filter berdasarkan tanggal
            $tanggalMulai = $request->query('tanggal_mulai', today()->toDateString());
            $tanggalAkhir = $request->query('tanggal_akhir', today()->toDateString());

            $query
                ->where('status_rawat', 'RALAN')
                ->whereBetween('waktu_registrasi', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);

            // Filter berdasarkan status_periksa, jaminan, status_bayar, poli, dokter
            if ($request->filled('status_periksa')) {
                $query->where('status_periksa', $request->status_periksa);
            }
            if ($request->filled('jaminan')) {
                $query->where('jaminan', $request->jaminan);
            }
            if ($request->filled('status_bayar')) {
                $query->where('status_bayar', $request->status_bayar);
            }
            if ($request->filled('poli')) {
                $query->where('poli', $request->poli);
            }
            if ($request->filled('dokter')) {
                $query->where('dokter', $request->dokter);
            }

            // Filter berdasarkan no_rm, nama_pasien, no_ktp di tabel pasien
            if ($request->filled('cari')) {
                $cari = $request->cari;
                $query->whereHas('pasienData', function ($q) use ($cari) {
                    $q->where('no_rm', 'LIKE', "%$cari%")
                        ->orWhere('nama_pasien', 'LIKE', "%$cari%")
                        ->orWhere('no_ktp', 'LIKE', "%$cari%");
                });
            }

            $sortBy = $request->query('sort_by', 'waktu_registrasi');
            $sortOrder = $request->query('sort_order', 'asc');

            if (!in_array($sortBy, ['waktu_registrasi'])) {
                $sortBy = 'waktu_registrasi';
            }

            $query->orderBy($sortBy, $sortOrder);

            // Ambil data
            $registrasi = $query->with('pasienData')
                ->with('poliData')
                ->with('dokterData')
                ->with('jaminanData')
                ->get();

            return response()->json([
                'data' => $registrasi
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function pasienRanap(Request $request)
    {
        try {
            $query = Registrasi::query();

            // Filter berdasarkan tanggal
            $tanggalMulai = $request->query('tanggal_mulai', today()->toDateString());
            $tanggalAkhir = $request->query('tanggal_akhir', today()->toDateString());

            $query
                ->join('riwayat_kamar_pasien', 'registrasi.no_rawat', '=', 'riwayat_kamar_pasien.no_rawat')
                ->join('bed', 'riwayat_kamar_pasien.bed', '=', 'bed.id')
                ->join('bangsal', 'bed.bangsal', '=', 'bangsal.id')
                ->where('status_rawat', 'RANAP')
                ->whereBetween('waktu_registrasi', [$tanggalMulai . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);

            // Filter berdasarkan status_periksa, jaminan, status_bayar, poli, dokter
            if ($request->filled('jaminan')) {
                $query->where('jaminan', $request->jaminan);
            }
            if ($request->filled('status_bayar')) {
                $query->where('status_bayar', $request->status_bayar);
            }
            if ($request->filled('dokter')) {
                $query->where('dokter', $request->dokter);
            }

            // Filter berdasarkan no_rm, nama_pasien, no_ktp di tabel pasien
            if ($request->filled('cari')) {
                $cari = $request->cari;
                $query->whereHas('pasienData', function ($q) use ($cari) {
                    $q->where('no_rm', 'LIKE', "%$cari%")
                        ->orWhere('nama_pasien', 'LIKE', "%$cari%")
                        ->orWhere('no_ktp', 'LIKE', "%$cari%");
                });
            }

            $sortBy = $request->query('sort_by', 'waktu_registrasi');
            $sortOrder = $request->query('sort_order', 'asc');

            if (!in_array($sortBy, ['waktu_registrasi'])) {
                $sortBy = 'waktu_registrasi';
            }

            $query->orderBy($sortBy, $sortOrder);

            // Ambil data
            $registrasi = $query->with('pasienData')
                ->with('dokterData')
                ->with('jaminanData')
                ->get();

            return response()->json([
                'data' => $registrasi
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'poli' => 'required|string|exists:poli,id',
            'dokter' => 'required|string|exists:dokter,id',
            'jaminan' => 'required|string|exists:jaminan,id',
            'pasien' => 'required|string|exists:pasien,no_rm',
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'poli.exists' => 'Poli tidak ditemukan',
            'dokter.exists' => 'Dokter tidak ditemukan',
            'pasien.exists' => 'Pasien tidak ditemukan',
            'jaminan.exists' => 'Jaminan tidak ditemukan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $nomerRawat = now()->format('YmdHis') . rand(100, 999);

            $registrasiBaru = Registrasi::create([
                'no_rawat' => $nomerRawat,
                'waktu_registrasi' => now(),
                'poli' => $request->poli,
                'dokter' => $request->dokter,
                'jaminan' => $request->jaminan,
                'pasien' => $request->pasien,
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Registrasi Baru berhasil',
                'data' => $registrasiBaru
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $dataRegis = Registrasi::where('no_rawat', $id)
                ->with('pasienData')
                ->with('poliData')
                ->with('dokterData')
                ->with('jaminanData')->first();

            if (!$dataRegis) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Success',
                'data' => $dataRegis
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'poli' => 'sometimes|string|exists:poli,id',
            'dokter' => 'sometimes|string|exists:dokter,id',
            'jaminan' => 'sometimes|string|exists:jaminan,id',
            'waktu_registrasi' => 'sometimes|date_format:Y-m-d H:i:s|before_or_equal:now',
        ], [
            'string' => 'Tipe data tidak valid',
            'poli.exists' => 'Poli tidak ditemukan',
            'dokter.exists' => 'Dokter tidak ditemukan',
            'jaminan.exists' => 'Jaminan tidak ditemukan',
            'waktu_registrasi.before_or_equal' => 'Waktu tidak boleh melebihi waktu saat ini',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $dataRegis = Registrasi::where('no_rawat', $id)->first();

            if (!$dataRegis) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $updateData = [];

            // Update dokter jika dikirim dalam request
            if ($request->filled('dokter')) {
                $updateData['dokter'] = $request->dokter;
            }

            // Update jaminan jika dikirim dalam request
            if ($request->filled('jaminan')) {
                $updateData['jaminan'] = $request->jaminan;
            }

            if ($request->filled('poli')) {
                $updateData['poli'] = $request->poli;
            }

            if ($request->filled('waktu_registrasi')) {
                $updateData['waktu_registrasi'] = $request->waktu_registrasi;
            }

            if (!empty($updateData)) {
                $dataRegis->update($updateData);
            } else {
                return response()->json([
                    'message' => 'Tidak ada data yang diperbarui'
                ], 422);
            }

            DB::commit();

            return response()->json([
                'message' => 'Data Registrasi berhasil diperbarui',
                'data' => $dataRegis
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan server: ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dataRegis = Registrasi::where('no_rawat', $id)->first();

            if (!$dataRegis) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dataRegis->delete();
            return response()->json([
                'message' => 'Data Registrasi deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
