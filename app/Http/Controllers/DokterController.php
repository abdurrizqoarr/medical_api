<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $spesialisFilter = $request->query('spesialis');

        $query = Dokter::query();

        if ($search) {
            $query->where('nama', 'like', "%$search%");
        }

        if ($spesialisFilter) {
            $query->where('spesialis', $spesialisFilter);
        }

        $dokter = $query->get();

        return response()->json(['data' => $dokter], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama' => 'required|string|max:240',
            'izin_praktek' => 'nullable|string|max:60',
            'spesialis' => 'required|string|max:40|exists:spesialis,spesialis',
            'pegawai' => 'required|string|max:240',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $dokter = Dokter::create([
                'nama' => $request->nama,
                'izin_praktek' => $request->izin_praktek,
                'spesialis' => $request->spesialis,
                'pegawai' => $request->pegawai,
            ]);

            return response()->json(['message' => 'Dokter created successfully', 'data' => $dokter], 201);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
