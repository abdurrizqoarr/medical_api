<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisTindakanRalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisTindakanRalanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $query = JenisTindakanRalan::query();

            if ($search) {
                $query->where('nama_perawatan', 'like', "%$search%");
            }

            $jenisTindakanRalan = $query->paginate(10);

            return response()->json([
                'data' => $jenisTindakanRalan
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
            'material' => 'nullable|numeric|min:0',
            'tarif_dokter' => 'nullable|numeric|min:0',
            'tarif_perawat' => 'nullable|numeric|min:0',
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
            $material = $request->material ?? 0;
            $tarif_dokter = $request->tarif_dokter ?? 0;
            $tarif_perawat = $request->tarif_perawat ?? 0;

            $total_tarif = $bhp + $kso + $manajemen + $material + $tarif_dokter + $tarif_perawat;

            $data = JenisTindakanRalan::create([
                'nama_perawatan' => $request->nama_perawatan,
                'total_tarif' => $total_tarif,
                'bhp' => $bhp,
                'kso' => $kso,
                'manajemen' => $manajemen,
                'material' => $material,
                'tarif_dokter' => $tarif_dokter,
                'tarif_perawat' => $tarif_perawat,
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
            'material' => 'sometimes|numeric|min:0',
            'tarif_dokter' => 'sometimes|numeric|min:0',
            'tarif_perawat' => 'sometimes|numeric|min:0',
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 422);
        }

        try {
            $data = JenisTindakanRalan::find($id);

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Perbarui nilai yang ada, jika tidak diberikan gunakan nilai lama
            $bhp = $request->bhp ?? $data->bhp;
            $kso = $request->kso ?? $data->kso;
            $manajemen = $request->manajemen ?? $data->manajemen;
            $material = $request->material ?? $data->material;
            $tarif_dokter = $request->tarif_dokter ?? $data->tarif_dokter;
            $tarif_perawat = $request->tarif_perawat ?? $data->tarif_perawat;

            $total_tarif = $bhp + $kso + $manajemen + $material + $tarif_dokter + $tarif_perawat;

            $data->update([
                'nama_perawatan' => $request->nama_perawatan ?? $data->nama_perawatan,
                'total_tarif' => $total_tarif,
                'bhp' => $bhp,
                'kso' => $kso,
                'manajemen' => $manajemen,
                'material' => $material,
                'tarif_dokter' => $tarif_dokter,
                'tarif_perawat' => $tarif_perawat,
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
            $data = JenisTindakanRalan::find($id);

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
            $data = JenisTindakanRalan::withTrashed()->find($id);

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
