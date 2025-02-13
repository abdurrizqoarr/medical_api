<?php

namespace App\Http\Controllers;

use App\Models\Suku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $suku = Suku::all();
        } else {
            $suku = Suku::where('suku', 'like', "%$search%")->get();
        }
        return response()->json(['data' => $suku], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'suku' => 'required|string|max:120|unique:suku,suku',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $suku = Suku::create([
                'suku' => $request->suku
            ]);

            return response()->json(['message' => 'Suku created successfully', 'data' => $suku], 201);
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
            'suku' => 'required|string|max:120|unique:suku,suku,' . $id,
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $suku = Suku::where('id', $id)->update([
                'suku' => $request->suku
            ]);

            return response()->json(['message' => 'Suku Edited successfully', 'data' => $suku], 201);
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
            $suku = Suku::find($id);
            $suku->delete();
            return response()->json(['message' => 'suku deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
