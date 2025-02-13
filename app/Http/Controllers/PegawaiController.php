<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (empty($search)) {
            $pegawai = Pegawai::all();
        } else {
            $pegawai = Pegawai::where('nama', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->get();
        }
        return response()->json(['data' => $pegawai], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nik' => 'required|string|max:40|unique:pegawai,nik',
            'npwp' => 'nullable|string|max:40',
            'nip' => 'required|string|max:40|unique:pegawai,nip',
            'nama' => 'required|string|max:240',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
            'tempat_lahir' => 'required|string|max:120',
            'tanggal_lahir' => 'required|date',
            'stts_nikah' => 'nullable|in:BELUM MENIKAH,MENIKAH,JANDA,SINGLE',
            'alamat' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $pegawai = Pegawai::create([
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'stts_nikah' => $request->stts_nikah,
                'alamat' => $request->alamat,
            ]);

            return response()->json(['message' => 'Pegawai created successfully', 'data' => $pegawai], 201);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pegawai = Pegawai::find($id);
            return response()->json(['message' => 'Pegawai deleted successfully', 'data' => $pegawai], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'nik' => 'required|string|max:40|unique:pegawai,nik,' . $id,
            'npwp' => 'nullable|string|max:40',
            'nip' => 'required|string|max:40|unique:pegawai,nip,' . $id,
            'nama' => 'required|string|max:240',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
            'tempat_lahir' => 'required|string|max:120',
            'tanggal_lahir' => 'required|date',
            'stts_nikah' => 'nullable|in:BELUM MENIKAH,MENIKAH,JANDA,SINGLE',
            'alamat' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => null, 'message' => $validate->errors()->all()], 400);
        }

        try {
            $pegawai = Pegawai::where('id', $id)->create([
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'stts_nikah' => $request->stts_nikah,
                'alamat' => $request->alamat,
            ]);

            return response()->json(['message' => 'Pegawai created successfully', 'data' => $pegawai], 201);
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
            $pegawai = Pegawai::find($id);
            $pegawai->delete();
            return response()->json(['message' => 'Pegawai deleted successfully', 'data' => null], 200);
        } catch (\Throwable $th) {
            return response()->json(['data' => null, 'message' => $th->getMessage()], 404);
        }
    }
}
