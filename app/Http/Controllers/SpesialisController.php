<?php

namespace App\Http\Controllers;

use App\Models\Spesialis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpesialisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $spesialis = Spesialis::all();
            } else {
                $spesialis = Spesialis::where('spesialis', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $spesialis], 200);
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
            'spesialis' => 'required|string|max:120|unique:spesialis,spesialis',
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
            $spesialis = Spesialis::create([
                'spesialis' => $request->spesialis
            ]);

            return response()->json(['message' => 'Spesialis created successfully', 'data' => $spesialis], 201);
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
            'spesialis' => 'required|string|max:120|unique:spesialis,spesialis,' . $id,
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()->all()], 400);
        }

        try {
            $spesialis = spesialis::where('id', $id)->update([
                'spesialis' => $request->spesialis
            ]);

            return response()->json([
                'message' => 'Spesialis Edited successfully',
                'data' => $spesialis
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
            $spesialis = Spesialis::find($id);

            if (!$spesialis) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $spesialis->delete();
            return response()->json([
                'message' => 'Spesialis deleted successfully'
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
            $spesialis = Spesialis::onlyTrashed()->find($id);

            if (!$spesialis) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $spesialis->restore();

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
