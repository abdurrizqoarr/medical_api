<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $kecamatan = Kecamatan::all();
            } else {
                $kecamatan = Kecamatan::where('kecamatan', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $kecamatan], 200);
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
            'kecamatan' => 'required|string|max:120|unique:kecamatan,kecamatan',
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 400);
        }

        try {
            $kecamatan = Kecamatan::create([
                'kecamatan' => $request->kecamatan
            ]);

            return response()->json([
                'message' => 'Kecamatan created successfully',
                'data' => $kecamatan
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
            'kecamatan' => 'required|string|max:120|unique:kecamatan,kecamatan,' . $id,
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 400);
        }

        try {
            $kecamatan = Kecamatan::where('id', $id)->update([
                'kecamatan' => $request->kecamatan
            ]);

            return response()->json([
                'message' => 'Kecamatan Edited successfully',
                'data' => $kecamatan
            ], 201);
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
            $kecamatan = Kecamatan::find($id);

            if (!$kecamatan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $kecamatan->delete();
            return response()->json([
                'message' => 'Kecamatan deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
