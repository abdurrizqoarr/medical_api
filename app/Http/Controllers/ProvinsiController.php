<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $provinsi = Provinsi::all();
            } else {
                $provinsi = Provinsi::where('provinsi', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $provinsi], 200);
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
            'provinsi' => 'required|string|max:120|unique:provinsi,provinsi',
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
            $provinsi = Provinsi::create([
                'provinsi' => $request->provinsi
            ]);

            return response()->json([
                'message' => 'Provinsi created successfully',
                'data' => $provinsi
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
            'provinsi' => 'required|string|max:120|unique:provinsi,provinsi,' . $id,
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
            $provinsi = Provinsi::where('id', $id)->first();

            if (!$provinsi) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $provinsi->update([
                'provinsi' => $request->provinsi
            ]);

            return response()->json([
                'message' => 'Provinsi Edited successfully',
                'data' => $provinsi
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
            $provinsi = Provinsi::find($id);

            if (!$provinsi) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $provinsi->delete();
            return response()->json(['message' => 'Provinsi deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $provinsi = Provinsi::onlyTrashed()->find($id);

            if (!$provinsi) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $provinsi->restore();

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
