<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $kelurahan = Kelurahan::all();
            } else {
                $kelurahan = Kelurahan::where('kelurahan', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $kelurahan], 200);
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
            'kelurahan' => 'required|string|max:120|unique:kelurahan,kelurahan',
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
            $kelurahan = Kelurahan::create([
                'kelurahan' => $request->kelurahan
            ]);

            return response()->json([
                'message' => 'Kelurahan created successfully',
                'data' => $kelurahan
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
            'kelurahan' => 'required|string|max:120|unique:kelurahan,kelurahan,' . $id,
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
            $kelurahan = Kelurahan::where('id', $id)->first();

            if (!$kelurahan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $kelurahan->update([
                'kelurahan' => $request->kelurahan
            ]);

            return response()->json([
                'message' => 'Kelurahan Edited successfully',
                'data' => $kelurahan
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
            $kelurahan = Kelurahan::find($id);

            if (!$kelurahan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $kelurahan->delete();
            return response()->json(['message' => 'kelurahan deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $kelurahan = Kelurahan::onlyTrashed()->find($id);

            if (!$kelurahan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $kelurahan->restore();

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
