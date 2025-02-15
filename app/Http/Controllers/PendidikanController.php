<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $pendidikan = Pendidikan::all();
            } else {
                $pendidikan = Pendidikan::where('jenjang_pendidikan', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $pendidikan], 200);
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
            'pendidikan' => 'required|string|max:120|unique:pendidikan,jenjang_pendidikan',
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
            $pendidikan = Pendidikan::create([
                'jenjang_pendidikan' => $request->pendidikan
            ]);

            return response()->json(['message' => 'Pendidikan created successfully', 'data' => $pendidikan], 201);
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
            'pendidikan' => 'required|string|max:120|unique:pendidikan,jenjang_pendidikan,' . $id,
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
            $pendidikan = Pendidikan::where('id', $id)->first();

            if (!$pendidikan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pendidikan->update([
                'jenjang_pendidikan' => $request->pendidikan
            ]);

            return response()->json([
                'message' => 'Pendidikan Edited successfully',
                'data' => $pendidikan
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
            $pendidikan = Pendidikan::find($id);

            if (!$pendidikan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pendidikan->delete();
            return response()->json(['message' => 'Pendidikan deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $pendidikan = Pendidikan::onlyTrashed()->find($id);

            if (!$pendidikan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $pendidikan->restore();

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
