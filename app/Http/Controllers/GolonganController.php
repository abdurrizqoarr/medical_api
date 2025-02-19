<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GolonganController extends Controller
{
    // Menampilkan daftar golongan dengan pencarian
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            if (empty($search)) {
                $depo = Golongan::all();
            } else {
                $depo = Golongan::where('golongan', 'like', "%$search%")->get();
            }
            return response()->json(['data' => $depo], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Menyimpan golongan baru
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'golongan' => 'required|string|max:120|unique:golongan,golongan',
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
            $golongan = Golongan::create($request->all());

            return response()->json([
                'message' => 'Gologan created successfully',
                'data' => $golongan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Memperbarui data golongan
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'golongan' => 'required|string|max:120|unique:golongan,golongan,' . $id,
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
            $golongan = Golongan::where('id', $id)->first();

            if (!$golongan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $golongan->update([
                'golongan' => $request->golongan
            ]);

            return response()->json([
                'message' => 'Gologan edit successfully',
                'data' => $golongan
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
        $golongan = Golongan::find($id);

        if (!$golongan) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        try {
            $golongan->delete(); // Soft delete

            return response()->json([
                'message' => 'Golongan deleted successfully'
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
            $query = Golongan::onlyTrashed();  // Hanya mengambil data yang dihapus (soft deleted)

            // Pencarian berdasarkan kolom 'golongan' yang sudah dihapus
            if ($request->has('search') && $request->search != '') {
                $query->where('golongan', 'like', '%' . $request->search . '%');
            }

            // Ambil hasil pencarian
            $trashedGolongs = $query->get();

            return response()->json([
                'message' => 'Succes',
                'data' => $trashedGolongs
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
            $golongan = Golongan::onlyTrashed()->find($id);

            // Jika tidak ditemukan, kembalikan response error
            if (!$golongan) {
                return response()->json(['message' => 'Golongan not found or not deleted'], 404);
            }

            // Melakukan restore pada golongan yang dihapus
            $golongan->restore();

            // Kembalikan response setelah berhasil mengembalikan data
            return response()->json(['message' => 'Golongan restored successfully', 'data' => $golongan]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
