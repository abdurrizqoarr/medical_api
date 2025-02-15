<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jaminan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JaminanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $jaminan = Jaminan::all();
            } else {
                $jaminan = Jaminan::where('jaminan', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $jaminan], 200);
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
            'jaminan' => 'required|string|max:120|unique:jaminan,jaminan',
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
            $jaminan = Jaminan::create([
                'jaminan' => $request->jaminan
            ]);

            return response()->json([
                'message' => 'jaminan created successfully',
                'data' => $jaminan
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
            'jaminan' => 'required|string|max:120|unique:jaminan,jaminan,' . $id,
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
            $jaminan = Jaminan::where('id', $id)->first();

            if (!$jaminan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $jaminan->update([
                'jaminan' => $request->jaminan
            ]);

            return response()->json([
                'message' => 'jaminan Edited successfully',
                'data' => $jaminan
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
            $jaminan = Jaminan::find($id);

            if (!$jaminan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $jaminan->delete();
            return response()->json([
                'message' => 'jaminan deleted successfully'
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
            $jaminan = Jaminan::onlyTrashed()->find($id);

            if (!$jaminan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $jaminan->restore();

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
