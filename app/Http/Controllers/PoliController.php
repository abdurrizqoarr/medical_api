<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $poli = Poli::all();
        } else {
            $poli = Poli::where('poli', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $poli], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'poli' => 'required|string|max:120|unique:poli,poli',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $poli = Poli::create([
                'poli' => $request->poli
            ]);

            return response()->json(['message' => 'Poli created successfully', 'data' => $poli], 201);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'poli' => 'required|string|max:120|unique:poli,poli,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $poli = Poli::where('id', $id)->update([
                'poli' => $request->poli
            ]);

            return response()->json(['message' => 'Poli Edited successfully', 'data' => $poli], 201);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $poli = Poli::find($id);

            if (!$poli) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $poli->delete();
            return response()->json(['message' => 'Poli deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $poli = Poli::onlyTrashed()->find($id);

            if (!$poli) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $poli->restore();

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
