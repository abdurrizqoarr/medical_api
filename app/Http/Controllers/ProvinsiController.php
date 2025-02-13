<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $provinsi = Provinsi::all();
        } else {
            $provinsi = Provinsi::where('provinsi', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $provinsi], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'provinsi' => 'required|string|max:120|unique:provinsi,provinsi',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $provinsi = Provinsi::create([
                'provinsi' => $request->provinsi
            ]);

            return response()->json(['message' => 'Provinsi created successfully', 'data' => $provinsi], 201);
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
            'provinsi' => 'required|string|max:120|unique:provinsi,provinsi,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $provinsi = Provinsi::where('id', $id)->update([
                'provinsi' => $request->provinsi
            ]);

            return response()->json(['message' => 'Provinsi Edited successfully', 'data' => $provinsi], 201);
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
            $provinsi = Provinsi::find($id);
            $provinsi->delete();
            return response()->json(['message' => 'Provinsi deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
