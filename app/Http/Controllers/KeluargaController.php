<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $keluarga = Keluarga::all();
            } else {
                $keluarga = Keluarga::where('keluarga', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $keluarga], 200);
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
            'keluarga' => 'required|string|max:120|unique:keluarga,keluarga',
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
            $keluarga = Keluarga::create([
                'keluarga' => $request->keluarga
            ]);

            return response()->json([
                'message' => 'Keluarga created successfully',
                'data' => $keluarga
            ], 201);
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
            'keluarga' => 'required|string|max:120|unique:keluarga,keluarga,' . $id,
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
            $keluarga = Keluarga::where('id', $id)->first();

            if (!$keluarga) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $keluarga->update([
                'keluarga' => $request->keluarga
            ]);

            return response()->json([
                'message' => 'Keluarga Edited successfully',
                'data' => $keluarga
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
            $keluarga = Keluarga::find($id);

            if (!$keluarga) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $keluarga->delete();
            return response()->json([
                'message' => 'Keluarga deleted successfully'
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
            $keluarga = Keluarga::onlyTrashed()->find($id);

            if (!$keluarga) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $keluarga->restore();

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
