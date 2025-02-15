<?php

namespace App\Http\Controllers;

use App\Models\Suku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $suku = Suku::all();
            } else {
                $suku = Suku::where('suku', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $suku], 200);
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
            'suku' => 'required|string|max:120|unique:suku,suku',
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
            $suku = Suku::create([
                'suku' => $request->suku
            ]);

            return response()->json(['message' => 'Suku created successfully', 'data' => $suku], 201);
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
            'suku' => 'required|string|max:120|unique:suku,suku,' . $id,
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
            $suku = Suku::where('id', $id)->first();

            if (!$suku) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $suku->update([
                'suku' => $request->suku
            ]);

            return response()->json([
                'message' => 'Suku Edited successfully',
                'data' => $suku
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
            $suku = Suku::find($id);

            if (!$suku) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $suku->delete();
            return response()->json(['message' => 'suku deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $suku = Suku::onlyTrashed()->find($id);

            if (!$suku) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $suku->restore();

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
