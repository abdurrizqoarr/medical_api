<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $keluarga = Keluarga::all();
        } else {
            $keluarga = Keluarga::where('keluarga', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $keluarga], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'keluarga' => 'required|string|max:120|unique:keluarga,keluarga',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $keluarga = Keluarga::create([
                'keluarga' => $request->keluarga
            ]);

            return response()->json(['message' => 'Keluarga created successfully', 'data' => $keluarga], 201);
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
            'keluarga' => 'required|string|max:120|unique:keluarga,keluarga,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $keluarga = Keluarga::where('id', $id)->update([
                'keluarga' => $request->keluarga
            ]);

            return response()->json(['message' => 'Keluarga Edited successfully', 'data' => $keluarga], 201);
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
            $keluarga = Keluarga::find($id);
            $keluarga->delete();
            return response()->json(['message' => 'Keluarga deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
