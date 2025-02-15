<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $spesialisFilter = $request->query('spesialis');

            $query = Dokter::query();

            if ($search) {
                $query->where('nama', 'like', "%$search%");
            }

            if ($spesialisFilter) {
                $query->where('spesialis', $spesialisFilter);
            }

            $dokter = $query->get();

            return response()->json(['data' => $dokter], 200);
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
            'izin_praktek' => 'nullable|string|max:100',
            'spesialis' => 'required|string|exists:spesialis,id',
            'pegawai' => 'required|string|exists:pegawai,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $dokter = Dokter::create([
                'izin_praktek' => $request->izin_praktek,
                'spesialis' => $request->spesialis,
                'pegawai' => $request->pegawai,
            ]);

            return response()->json(['message' => 'Dokter created successfully', 'data' => $dokter], 201);
        } catch (\Throwable $th) {
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
            $dokter = Dokter::first($id);

            if (!$dokter) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json(['message' => 'Success', 'data' => $dokter], 200);
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
            'izin_praktek' => 'nullable|string|max:100',
            'spesialis' => 'required|string|exists:spesialis,id',
            'pegawai' => 'required|string|exists:pegawai,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $dokter = Dokter::where('id', $id)->first();

            if (!$dokter) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dokter->update([
                'izin_praktek' => $request->izin_praktek,
                'spesialis' => $request->spesialis,
                'pegawai' => $request->pegawai,
            ]);

            return response()->json([
                'message' => 'Dokter update successfully',
                'data' => $dokter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dokter = Dokter::find($id);

            if (!$dokter) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dokter->delete();
            return response()->json([
                'message' => 'Dokter deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
