<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $bahasa = Bahasa::all();
            } else {
                $bahasa = Bahasa::where('bahasa', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $bahasa], 200);
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
            'bahasa' => 'required|string|max:120|unique:bahasa,bahasa',
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
            $bahasa = Bahasa::create([
                'bahasa' => $request->bahasa
            ]);

            return response()->json([
                'message' => 'Bahasa created successfully',
                'data' => $bahasa
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
            'bahasa' => 'required|string|max:120|unique:bahasa,bahasa,' . $id,
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Bahasa yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 400);
        }

        try {
            $bahasa = Bahasa::where('id', $id)->update([
                'bahasa' => $request->bahasa
            ]);

            return response()->json([
                'message' => 'Bahasa Edited successfully',
                'data' => $bahasa
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
            $bahasa = Bahasa::find($id);

            if (!$bahasa) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $bahasa->delete();
            return response()->json(['message' => 'Bahasa deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $bahasa = Bahasa::onlyTrashed()->find($id);

            if (!$bahasa) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $bahasa->restore();

            return response()->json([
                'message' => 'Data bahasa berhasil dikembalikan'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }
}
