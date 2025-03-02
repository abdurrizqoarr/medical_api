<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');

            $query = Pasien::query()->leftJoin('keluarga', 'pasien.keluarga', '=', 'keluarga.id')
                ->leftJoin('pendidikan', 'pasien.pendidikan', '=', 'pendidikan.id')
                ->leftJoin('cacat_fisik', 'pasien.cacat_fisik', '=', 'cacat_fisik.id')
                ->leftJoin('suku', 'pasien.suku', '=', 'suku.id')
                ->leftJoin('bahasa', 'pasien.bahasa', '=', 'bahasa.id')
                ->leftJoin('provinsi', 'pasien.provinsi', '=', 'provinsi.id')
                ->leftJoin('kabupaten', 'pasien.kabupaten', '=', 'kabupaten.id')
                ->leftJoin('kecamatan', 'pasien.kecamatan', '=', 'kecamatan.id')
                ->leftJoin('kelurahan', 'pasien.kelurahan', '=', 'kelurahan.id')
                ->select([
                    'pasien.no_rm',
                    'pasien.nama_pasien',
                    'pasien.no_ktp',
                    'pasien.jenis_kelamin',
                    'pasien.tempat_lahir',
                    'pasien.tanggal_lahir',
                    'pasien.nama_ibu',
                    'pasien.alamat',
                    'pasien.gol_darah',
                    'pasien.pekerjaan',
                    'pasien.stts_nikah',
                    'pasien.agama',
                    'pasien.tgl_daftar',
                    'pasien.no_tlp',
                    'pasien.kelurahan as kelurahan_id',
                    'pasien.kecamatan as kecamatan_id',
                    'pasien.kabupaten as kabupaten_id',
                    'pasien.suku as suku_id',
                    'pasien.bahasa as bahasa_id',
                    'pasien.provinsi as provinsi_id',
                    'pasien.cacat_fisik as cacatFisik_id',
                    'pasien.pendidikan as pendidikan_id',
                    'pasien.keluarga as keluarga_id',
                    'keluarga.keluarga',
                    'kelurahan.kelurahan',
                    'kecamatan.kecamatan',
                    'kabupaten.kabupaten',
                    'suku.suku',
                    'bahasa.bahasa',
                    'provinsi.provinsi',
                    'cacat_fisik.cacat_fisik',
                    'pendidikan.jenjang_pendidikan as pendidikan',
                ]);

            // Pencarian dengan grouping
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_rm', 'like', "%$search%")
                        ->orWhere('nama_pasien', 'like', "%$search%")
                        ->orWhere('no_ktp', 'like', "%$search%");
                });
            }

            // Filter dinamis
            $filters = [
                'kelurahan' => $request->query('kelurahan'),
                'kecamatan' => $request->query('kecamatan'),
                'kabupaten' => $request->query('kabupaten'),
                'suku' => $request->query('suku'),
                'bahasa' => $request->query('bahasa'),
                'provinsi' => $request->query('provinsi'),
                'cacat_fisik' => $request->query('cacat_fisik'),
                'pendidikan' => $request->query('pendidikan'),
                'keluarga' => $request->query('keluarga'),
                'agama' => $request->query('agama'),
            ];

            foreach ($filters as $column => $value) {
                if ($value) {
                    $query->where($column, $value);
                }
            }

            // Pagination
            $pasien = $query->orderBy('no_rm')->get();

            return response()->json(['data' => $pasien], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:40|unique:pasien,no_ktp',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
            'tempat_lahir' => 'required|string|max:200',
            'tanggal_lahir' => 'required|date',
            'nama_ibu' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'gol_darah' => 'required|in:A,B,O,AB,-',
            'pekerjaan' => 'nullable|string|max:240',
            'stts_nikah' => 'required|in:BELUM MENIKAH,MENIKAH,JANDA,DUDHA',
            'agama' => 'required|string|max:120',
            'no_tlp' => 'nullable|string|max:40',
            'kelurahan' => 'nullable|uuid|exists:kelurahan,id',
            'kecamatan' => 'nullable|uuid|exists:kecamatan,id',
            'kabupaten' => 'nullable|uuid|exists:kabupaten,id',
            'suku' => 'nullable|uuid|exists:suku,id',
            'bahasa' => 'nullable|uuid|exists:bahasa,id',
            'provinsi' => 'nullable|uuid|exists:provinsi,id',
            'cacat_fisik' => 'nullable|uuid|exists:cacat_fisik,id',
            'pendidikan' => 'nullable|uuid|exists:pendidikan,id',
            'keluarga' => 'nullable|uuid|exists:keluarga,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Generate nomor rekam medis (no_rm) dengan format 6 digit
            $lastPatient = Pasien::orderBy('no_rm', 'desc')->first();
            $nextNumber = $lastPatient ? (int) $lastPatient->no_rm + 1 : 1;
            $no_rm = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // Simpan data ke database
            $pasien = Pasien::create([
                'no_rm' => $no_rm,
                'nama_pasien' => $request->nama_pasien,
                'no_ktp' => $request->no_ktp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
                'nama_ibu' => $request->nama_ibu,
                'alamat' => $request->alamat,
                'gol_darah' => $request->gol_darah,
                'pekerjaan' => $request->pekerjaan,
                'stts_nikah' => $request->stts_nikah,
                'agama' => $request->agama,
                'no_tlp' => $request->no_tlp,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'tgl_daftar' => now(),
                'kabupaten' => $request->kabupaten,
                'suku' => $request->suku,
                'bahasa' => $request->bahasa,
                'provinsi' => $request->provinsi,
                'cacat_fisik' => $request->cacat_fisik,
                'pendidikan' => $request->pendidikan,
                'keluarga' => $request->keluarga,
            ]);

            DB::commit();

            // Kembalikan response sukses
            return response()->json([
                'message' => 'Pasien berhasil ditambahkan.',
                'data' => $pasien
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

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
            $pasien = Pasien::first($id);

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Success',
                'data' => $pasien
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
            'nama_pasien' => 'sometimes|required|string|max:255',
            'no_ktp' => [
                'sometimes',
                'required',
                'string',
                'max:40',
                Rule::unique('pasien', 'no_ktp')->ignore($id), // Mengabaikan pasien dengan ID yang sedang diperbarui
            ],
            'jenis_kelamin' => 'sometimes|required|in:PRIA,WANITA',
            'tempat_lahir' => 'sometimes|required|string|max:200',
            'tanggal_lahir' => 'sometimes|required|date',
            'nama_ibu' => 'sometimes|nullable|string|max:255',
            'alamat' => 'sometimes|required|string',
            'gol_darah' => 'sometimes|required|in:A,B,O,AB,-',
            'pekerjaan' => 'sometimes|nullable|string|max:240',
            'stts_nikah' => 'sometimes|required|in:BELUM MENIKAH,MENIKAH,JANDA,DUDHA',
            'agama' => 'sometimes|required|string|max:120',
            'no_tlp' => 'sometimes|nullable|string|max:40',
            'kelurahan' => 'sometimes|nullable|uuid|exists:kelurahan,id',
            'kecamatan' => 'sometimes|nullable|uuid|exists:kecamatan,id',
            'kabupaten' => 'sometimes|nullable|uuid|exists:kabupaten,id',
            'suku' => 'sometimes|nullable|uuid|exists:suku,id',
            'bahasa' => 'sometimes|nullable|uuid|exists:bahasa,id',
            'provinsi' => 'sometimes|nullable|uuid|exists:provinsi,id',
            'cacat_fisik' => 'sometimes|nullable|uuid|exists:cacat_fisik,id',
            'pendidikan' => 'sometimes|nullable|uuid|exists:pendidikan,id',
            'keluarga' => 'sometimes|nullable|uuid|exists:keluarga,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $pasien = Pasien::where('no_rm', $id)->first();

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pasien->update([
                'nama_pasien' => $request->nama_pasien,
                'no_ktp' => $request->no_ktp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_ibu' => $request->nama_ibu,
                'alamat' => $request->alamat,
                'gol_darah' => $request->gol_darah,
                'pekerjaan' => $request->pekerjaan,
                'stts_nikah' => $request->stts_nikah,
                'agama' => $request->agama,
                'tgl_daftar' => now(),
                'no_tlp' => $request->no_tlp,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'suku' => $request->suku,
                'bahasa' => $request->bahasa,
                'provinsi' => $request->provinsi,
                'cacat_fisik' => $request->cacat_fisik,
                'pendidikan' => $request->pendidikan,
                'keluarga' => $request->keluarga,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Pasien Edit successfully',
                'data' => $pasien
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

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
            $pasien = Pasien::where('no_rm', $id)->first();

            if (!$pasien) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pasien->delete();
            return response()->json([
                'message' => 'Pegawai deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
