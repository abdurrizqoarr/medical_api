<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $kabupaten = Kabupaten::all();
            } else {
                $kabupaten = Kabupaten::where('kabupaten', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $kabupaten], 200);
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
            'kabupaten' => 'required|string|max:120|unique:kabupaten,kabupaten',
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
            $kabupaten = Kabupaten::create([
                'kabupaten' => $request->kabupaten
            ]);

            return response()->json([
                'message' => 'Kabupaten created successfully',
                'data' => $kabupaten
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
            'kabupaten' => 'required|string|max:120|unique:kabupaten,kabupaten,' . $id,
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
            $kabupaten = Kabupaten::where('id', $id)->first();

            if (!$kabupaten) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $kabupaten->update([
                'kabupaten' => $request->kabupaten
            ]);

            return response()->json([
                'message' => 'Kabupaten Edited successfully',
                'data' => $kabupaten
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
            $kabupaten = Kabupaten::find($id);

            if (!$kabupaten) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $kabupaten->delete();
            return response()->json([
                'message' => 'Kabupaten deleted successfully'
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
            $kabupaten = Kabupaten::onlyTrashed()->find($id);

            if (!$kabupaten) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $kabupaten->restore();

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
