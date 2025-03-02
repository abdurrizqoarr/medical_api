<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataBarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');

            $query = DataBarang::query()
                ->leftJoin('satuan', 'data_barang.satuan', '=', 'satuan.id')
                ->leftJoin('jenis', 'data_barang.jenis', '=', 'jenis.id')
                ->leftJoin('kategori', 'data_barang.kategori', '=', 'kategori.id')
                ->leftJoin('golongan', 'data_barang.golongan', '=', 'golongan.id')
                ->select([
                    'data_barang.nama_brng',
                    'data_barang.satuan as satuan_id',
                    'data_barang.isi',
                    'data_barang.kapasitas',
                    'data_barang.h_dasar',
                    'data_barang.h_beli',
                    'data_barang.harga_karyawan',
                    'data_barang.harga_jual',
                    'data_barang.harga_bebas',
                    'data_barang.jenis as jenis_id',
                    'data_barang.kategori as kategori_id',
                    'data_barang.golongan as golongan_id',
                    'satuan.satuan as satuan',
                    'jenis.jenis as jenis',
                    'kategori.kategori as kategori',
                    'golongan.golongan as golongan',
                ]);

            if ($search) {
                $query->where('nama_brng', 'like', "%$search%");
            }

            // Filter dinamis
            $filters = [
                'jenis' => $request->query('jenis'),
                'kategori' => $request->query('kategori'),
                'golongan' => $request->query('golongan'),
            ];

            foreach ($filters as $column => $value) {
                if ($value) {
                    $query->where($column, $value);
                }
            }

            // Pagination
            $pasien = $query->orderBy('nama_brng')->get();

            return response()->json(['data' => $pasien], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_brng' => 'required|string',
            'satuan' => 'required|uuid|exists:satuan,id',
            'isi' => 'required|integer',
            'kapasitas' => 'required|integer',
            'h_dasar' => 'nullable|numeric',
            'h_beli' => 'nullable|numeric',
            'harga_karyawan' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'harga_bebas' => 'nullable|numeric',
            'jenis' => 'required|uuid|exists:jenis,id',
            'kategori' => 'required|uuid|exists:kategori,id',
            'golongan' => 'required|uuid|exists:golongan,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $dataBarang = DataBarang::create($request->all());

            return response()->json(['message' => 'Data barang berhasil ditambahkan', 'data' => $dataBarang], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_brng' => 'sometimes|required|string',
            'satuan' => 'sometimes|required|uuid|exists:satuan,id',
            'isi' => 'sometimes|required|integer',
            'kapasitas' => 'sometimes|required|integer',
            'h_dasar' => 'nullable|numeric',
            'h_beli' => 'nullable|numeric',
            'harga_karyawan' => 'nullable|numeric',
            'harga_jual' => 'nullable|numeric',
            'harga_bebas' => 'nullable|numeric',
            'jenis' => 'sometimes|required|uuid|exists:jenis,id',
            'kategori' => 'sometimes|required|uuid|exists:kategori,id',
            'golongan' => 'sometimes|required|uuid|exists:golongan,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $dataBarang = DataBarang::where('id', $id)->first();

            if (!$dataBarang) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dataBarang->update($request->all());

            return response()->json([
                'message' => 'Data barang Edited successfully',
                'data' => $dataBarang
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function destroy(string $id)
    {
        try {
            $dataBarang = DataBarang::find($id);

            if (!$dataBarang) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $dataBarang->delete();
            return response()->json([
                'message' => 'Data barang deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function trashed(Request $request)
    {
        try {
            $query = DataBarang::onlyTrashed();

            $search = $request->query('search');

            if ($search) {
                $query->where('nama_brng', 'like', "%$search%");
            }

            $filters = ['jenis', 'kategori', 'golongan'];

            foreach ($filters as $filter) {
                if ($value = $request->query($filter)) {
                    $query->where($filter, $value);
                }
            }

            $trashed = $query->get();

            return response()->json([
                'message' => 'Succes',
                'data' => $trashed
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $dataBarang = DataBarang::onlyTrashed()->find($id);

            if (!$dataBarang) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $dataBarang->restore();

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
