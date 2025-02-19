<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bangsal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BangsalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $bangsal = Bangsal::all();
            } else {
                $bangsal = Bangsal::where('bangsal', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $bangsal], 200);
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
            'bangsal' => 'required|string|max:120|unique:bangsal,bangsal',
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
            $bangsal = Bangsal::create([
                'bangsal' => $request->bangsal
            ]);

            return response()->json([
                'message' => 'Bangsal created successfully',
                'data' => $bangsal
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
            'bangsal' => 'required|string|max:120|unique:bangsal,bangsal,' . $id,
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
            $bangsal = Bangsal::where('id', $id)->first();

            if (!$bangsal) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $bangsal->update([
                'bangsal' => $request->bangsal
            ]);

            return response()->json([
                'message' => 'Bangsal Edited successfully',
                'data' => $bangsal
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
            $bangsal = Bangsal::find($id);

            if (!$bangsal) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $bangsal->delete();
            return response()->json(['message' => 'Bangsal deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $bangsal = Bangsal::onlyTrashed()->find($id);

            if (!$bangsal) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $bangsal->restore();

            return response()->json([
                'message' => 'Data bangsal berhasil dikembalikan'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }
}
