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
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $pegawai = Pegawai::all();
            } else {
                $pegawai = Pegawai::where('nama', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
                    ->orWhere('nip', 'like', "%$search%")
                    ->get();
            }
            return response()->json(['data' => $pegawai], 200);
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
            'nik' => 'required|string|max:40|unique:pegawai,nik',
            'npwp' => 'nullable|string|max:40',
            'nip' => 'required|string|max:40|unique:pegawai,nip',
            'nama' => 'required|string|max:240',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
            'tempat_lahir' => 'required|string|max:240',
            'tanggal_lahir' => 'required|date',
            'stts_nikah' => 'nullable|in:BELUM MENIKAH,MENIKAH,JANDA,SINGLE',
            'alamat' => 'required|string',
        ], [
            'required' => 'Form harus dilengkapi.',
            'unique' => 'Data yang sama telah digunakan.',
            'in' => 'Data tidak termasuk dalam opsi yang tersedia.',
            'date' => 'Format tanggal tidak valid.',
            'nik.max' => 'NIK maksimal 40 karakter.',
            'nip.max' => 'NIP maksimal 40 karakter.',
            'npwp.max' => 'NPWP maksimal 40 karakter.',
            'nama.max' => 'Nama maksimal 240 karakter.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 240 karakter.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
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
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pegawai = Pegawai::first($id);

            if (!$pegawai) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Success',
                'data' => $pegawai
            ], 200);
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
            'nik' => 'required|string|max:40|unique:pegawai,nik,' . $id,
            'npwp' => 'nullable|string|max:40',
            'nip' => 'required|string|max:40|unique:pegawai,nip,' . $id,
            'nama' => 'required|string|max:240',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
            'tempat_lahir' => 'required|string|max:120',
            'tanggal_lahir' => 'required|date',
            'stts_nikah' => 'nullable|in:BELUM MENIKAH,MENIKAH,JANDA,SINGLE',
            'alamat' => 'required|string',
        ], [
            'required' => 'Form harus dilengkapi.',
            'unique' => 'Data yang sama telah digunakan.',
            'in' => 'Data tidak termasuk dalam opsi yang tersedia.',
            'date' => 'Format tanggal tidak valid.',
            'nik.max' => 'NIK maksimal 40 karakter.',
            'nip.max' => 'NIP maksimal 40 karakter.',
            'npwp.max' => 'NPWP maksimal 40 karakter.',
            'nama.max' => 'Nama maksimal 240 karakter.',
            'tempat_lahir.max' => 'Tempat lahir maksimal 240 karakter.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $pegawai = Pegawai::where('id', $id)->first();

            if (!$pegawai) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pegawai->update([
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

            return response()->json([
                'message' => 'Pegawai Edit successfully',
                'data' => $pegawai
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
            $pegawai = Pegawai::find($id);

            if (!$pegawai) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pegawai->delete();
            return response()->json([
                'message' => 'Pegawai deleted successfully'
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
            $pegawai = Pegawai::onlyTrashed()->find($id);

            if (!$pegawai) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $pegawai->restore();

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
