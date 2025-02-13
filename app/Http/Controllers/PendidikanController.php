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
        $search = $request->query('search');
        if (empty($search)) {
            $pendidikan = Pendidikan::all();
        } else {
            $pendidikan = Pendidikan::where('jenjang_pendidikan', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $pendidikan], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'pendidikan' => 'required|string|max:120|unique:pendidikan,jenjang_pendidikan',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $pendidikan = Pendidikan::create([
                'jenjang_pendidikan' => $request->pendidikan
            ]);

            return response()->json(['message' => 'Pendidikan created successfully', 'data' => $pendidikan], 201);
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
            'pendidikan' => 'required|string|max:120|unique:pendidikan,jenjang_pendidikan,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $pendidikan = Pendidikan::where('id', $id)->update([
                'jenjang_pendidikan' => $request->pendidikan
            ]);

            return response()->json(['message' => 'Pendidikan Edited successfully', 'data' => $pendidikan], 201);
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
            $pendidikan = Pendidikan::find($id);
            $pendidikan->delete();
            return response()->json(['message' => 'Pendidikan deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
