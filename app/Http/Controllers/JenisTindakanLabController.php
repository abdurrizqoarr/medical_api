<?php

namespace App\Http\Controllers;

use App\Models\JenisTindakanLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisTindakanLabController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $query = JenisTindakanLab::query();

            if ($search) {
                $query->where('nama_perawatan', 'like', "%$search%");
            }

            $jenisTindakanLab = $query->paginate(10);

            return response()->json([
                'data' => $jenisTindakanLab
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
            'nama_perawatan' => 'required|string|max:255',
            'bhp' => 'nullable|numeric|min:0',
            'kso' => 'nullable|numeric|min:0',
            'manajemen' => 'nullable|numeric|min:0',
            'bagian_rs' => 'nullable|numeric|min:0',
            'tarif_dokter' => 'nullable|numeric|min:0',
            'tarif_petugas' => 'nullable|numeric|min:0',
            'tarif_perujuk' => 'nullable|numeric|min:0',
            'kategori' => 'required|in:PK,PA,MB',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 422);
        }

        try {
            // Hitung total tarif dari semua biaya
            $bhp = $request->bhp ?? 0;
            $kso = $request->kso ?? 0;
            $manajemen = $request->manajemen ?? 0;
            $bagian_rs = $request->bagian_rs ?? 0;
            $tarif_dokter = $request->tarif_dokter ?? 0;
            $tarif_petugas = $request->tarif_petugas ?? 0;
            $tarif_perujuk = $request->tarif_perujuk ?? 0;

            $total_tarif = $bhp + $kso + $manajemen + $bagian_rs + $tarif_dokter + $tarif_petugas+$tarif_perujuk;

            $data = JenisTindakanLab::create([
                'nama_perawatan' => $request->nama_perawatan,
                'total_tarif' => $total_tarif,
                'bhp' => $bhp,
                'kso' => $kso,
                'manajemen' => $manajemen,
                'bagian_rs' => $bagian_rs,
                'tarif_dokter' => $tarif_dokter,
                'tarif_petugas' => $tarif_petugas,
                'tarif_perujuk' => $tarif_perujuk
            ]);

            return response()->json([
                'message' => 'Data added successfully',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_perawatan' => 'sometimes|string|max:255',
            'bhp' => 'sometimes|numeric|min:0',
            'kso' => 'sometimes|numeric|min:0',
            'manajemen' => 'sometimes|numeric|min:0',
            'bagian_rs' => 'sometimes|numeric|min:0',
            'tarif_dokter' => 'sometimes|numeric|min:0',
            'tarif_petugas' => 'sometimes|numeric|min:0',
            'tarif_perujuk' => 'sometimes|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 422);
        }

        try {
            $data = JenisTindakanLab::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Perbarui nilai yang ada, jika tidak diberikan gunakan nilai lama
            $bhp = $request->bhp ?? 0;
            $kso = $request->kso ?? 0;
            $manajemen = $request->manajemen ?? 0;
            $bagian_rs = $request->bagian_rs ?? 0;
            $tarif_dokter = $request->tarif_dokter ?? 0;
            $tarif_petugas = $request->tarif_petugas ?? 0;
            $tarif_perujuk = $request->tarif_perujuk ?? 0;

            $total_tarif = $bhp + $kso + $manajemen + $bagian_rs + $tarif_dokter + $tarif_petugas+$tarif_perujuk;

            $data->update([
                'nama_perawatan' => $request->nama_perawatan ?? $data->nama_perawatan,
                'total_tarif' => $total_tarif,
                'bhp' => $bhp,
                'kso' => $kso,
                'manajemen' => $manajemen,
                'bagian_rs' => $bagian_rs,
                'tarif_dokter' => $tarif_dokter,
                'tarif_petugas' => $tarif_petugas,
                'tarif_perujuk' => $tarif_perujuk
            ]);

            return response()->json([
                'message' => 'Data updated successfully',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = JenisTindakanLab::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $data->delete();

            return response()->json(['message' => 'Data deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $data = JenisTindakanLab::withTrashed()->find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $data->restore();

            return response()->json([
                'message' => 'Data restored successfully',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
