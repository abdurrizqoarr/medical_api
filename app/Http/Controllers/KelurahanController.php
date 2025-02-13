<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $kelurahan = Kelurahan::all();
        } else {
            $kelurahan = Kelurahan::where('kelurahan', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $kelurahan], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kelurahan' => 'required|string|max:120|unique:kelurahan,kelurahan',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $kelurahan = Kelurahan::create([
                'kelurahan' => $request->kelurahan
            ]);

            return response()->json(['message' => 'Kelurahan created successfully', 'data' => $kelurahan], 201);
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
            'kelurahan' => 'required|string|max:120|unique:kelurahan,kelurahan,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $kelurahan = Kelurahan::where('id', $id)->update([
                'kelurahan' => $request->kelurahan
            ]);

            return response()->json(['message' => 'Kelurahan Edited successfully', 'data' => $kelurahan], 201);
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
            $kelurahan = Kelurahan::find($id);
            $kelurahan->delete();
            return response()->json(['message' => 'kelurahan deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
