<?php

namespace App\Http\Controllers;

use App\Models\CacatFisik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CacatFisikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $cacatFisik = CacatFisik::all();
            } else {
                $cacatFisik = CacatFisik::where('cacat_fisik', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $cacatFisik], 200);
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
            'cacat_fisik' => 'required|string|max:120|unique:cacat_fisik,cacat_fisik',
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $cacatFisik = CacatFisik::create([
                'cacat_fisik' => $request->cacat_fisik
            ]);

            return response()->json(['message' => 'Cacat Fisik created successfully', 'data' => $cacatFisik], 201);
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
            'cacat_fisik' => 'required|string|max:120|unique:cacat_fisik,cacat_fisik,' . $id,
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $cacatFisik = CacatFisik::where('id', $id)->first();

            if (!$cacatFisik) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $cacatFisik->update([
                'cacat_fisik' => $request->cacat_fisik
            ]);

            return response()->json([
                'message' => 'Cacat Fisik Edited successfully',
                'data' => $cacatFisik
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
            $cacatFisik = CacatFisik::find($id);

            if (!$cacatFisik) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $cacatFisik->delete();
            return response()->json([
                'message' => 'Cacat Fisik deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $cacatFisik = CacatFisik::onlyTrashed()->find($id);

            if (!$cacatFisik) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $cacatFisik->restore();

            return response()->json([
                'message' => 'Data berhasil dikembalikan'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
