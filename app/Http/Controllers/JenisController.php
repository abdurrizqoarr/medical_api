<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    // Menampilkan daftar golongan dengan pencarian
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $jenis = Jenis::all();
            } else {
                $jenis = Jenis::where('jenis', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $jenis], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'jenis' => 'required|string|max:120|unique:jenis,jenis',
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $jenis = Jenis::create($request->all());

            return response()->json([
                'message' => 'Jenis created successfully',
                'data' => $jenis
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'jenis' => 'required|string|max:120|unique:jenis,jenis,' . $id,
        ], [
            'required' => 'Form harus dilengkapi',
            'string' => 'Tipe data tidak valid',
            'max' => 'Maksimal 120 karakter',
            'unique' => 'Data yang sama telah disimpan',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $jenis = Jenis::where('id', $id)->first();

            if (!$jenis) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $jenis->update([
                'golongan' => $request->jenis
            ]);

            return response()->json([
                'message' => 'Gologan edit successfully',
                'data' => $jenis
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Menghapus golongan (soft delete)
    public function destroy($id)
    {
        $jenis = Jenis::find($id);

        if (!$jenis) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        try {
            $jenis->delete(); // Soft delete

            return response()->json([
                'message' => 'Jenis deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Menampilkan golongan yang telah dihapus (soft deleted)
    public function trashed(Request $request)
    {
        try {
            $query = Jenis::onlyTrashed();  // Hanya mengambil data yang dihapus (soft deleted)

            // Pencarian berdasarkan kolom 'golongan' yang sudah dihapus
            if ($request->has('search') && $request->search != '') {
                $query->where('jenis', 'like', '%' . $request->search . '%');
            }

            // Ambil hasil pencarian
            $trashedJenis = $query->get();

            return response()->json([
                'message' => 'Succes',
                'data' => $trashedJenis
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
            // Mencari golongan yang telah dihapus (soft deleted)
            $jenis = Jenis::onlyTrashed()->find($id);

            // Jika tidak ditemukan, kembalikan response error
            if (!$jenis) {
                return response()->json(['message' => 'Jenis not found or not deleted'], 404);
            }

            // Melakukan restore pada golongan yang dihapus
            $jenis->restore();

            // Kembalikan response setelah berhasil mengembalikan data
            return response()->json(['message' => 'Golongan restored successfully', 'data' => $jenis]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
