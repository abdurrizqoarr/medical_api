<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DepoObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $depo = DepoObat::all();
            } else {
                $depo = DepoObat::where('depo_obat', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $depo], 200);
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
            'depoObat' => 'required|string|max:120|unique:depo_obat,depo_obat',
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
            $depo = DepoObat::create([
                'depo_obat' => $request->depoObat
            ]);

            return response()->json([
                'message' => 'Depo created successfully',
                'data' => $depo
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
            'depoObat' => 'required|string|max:120|unique:depo_obat,depo_obat,' . $id,
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
            $depo = DepoObat::where('id', $id)->first();

            if (!$depo) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $depo->update([
                'depo_obat' => $request->depoObat
            ]);

            return response()->json([
                'message' => 'Depo Edited successfully',
                'data' => $depo
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
            $depo = DepoObat::find($id);

            if (!$depo) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $depo->delete();
            return response()->json(['message' => 'Depo deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        try {
            $depo = DepoObat::onlyTrashed()->find($id);

            if (!$depo) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $depo->restore();

            return response()->json([
                'message' => 'Data depo berhasil dikembalikan'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }
}
