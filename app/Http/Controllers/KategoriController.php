<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Fungsi untuk mendapatkan semua data kategori
    public function index(Request $request)
    {
        try {
            $query = Kategori::query();

            // Menambahkan pencarian berdasarkan kolom 'kategori'
            if ($request->has('search') && $request->search != '') {
                $query->where('kategori', 'like', '%' . $request->search . '%');
            }

            $kategoris = $query->get();
            return response()->json([
                'message' => 'Succes',
                'data' => $kategoris
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    // Fungsi untuk menambahkan data kategori baru
    public function store(Request $request)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'kategori' => 'required|string|max:120|unique:kategori,kategori',
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
            // Membuat data kategori baru
            $kategori = Kategori::create([
                'kategori' => $request->kategori,
            ]);

            return response()->json([
                'message' => 'Succes',
                'data' => $kategori
            ], 201);  // Mengembalikan data dengan status 201 (created)
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk mengupdate data kategori
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'kategori' => 'required|string|max:120|unique:kategori,kategori,' . $id,
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
            // Mencari kategori berdasarkan ID
            $kategori = Kategori::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$kategori) {
                return response()->json(['message' => 'Kategori not found'], 404);
            }

            // Mengupdate data kategori
            $kategori->update([
                'kategori' => $request->kategori,
            ]);

            return response()->json([
                'message' => 'Succes',
                'data' => $kategori
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk menghapus data kategori (soft delete)
    public function destroy($id)
    {
        try {
            // Mencari kategori berdasarkan ID
            $kategori = Kategori::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$kategori) {
                return response()->json(['message' => 'Kategori not found'], 404);
            }

            // Melakukan soft delete
            $kategori->delete();

            return response()->json([
                'message' => 'Kategori deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    // Fungsi untuk mengembalikan data yang telah dihapus (soft delete)
    public function restore($id)
    {
        try {
            // Mencari kategori yang sudah dihapus
            $kategori = Kategori::onlyTrashed()->find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$kategori) {
                return response()->json(['message' => 'Kategori not found or not deleted'], 404);
            }

            // Mengembalikan data yang telah dihapus
            $kategori->restore();

            return response()->json(['message' => 'Kategori restored successfully', 'data' => $kategori]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    public function trashed(Request $request)
    {
        try {
            $query = Kategori::onlyTrashed();  // Hanya mengambil data yang dihapus (soft deleted)

            if ($request->has('search') && $request->search != '') {
                $query->where('satuan', 'like', '%' . $request->search . '%');
            }

            // Ambil hasil pencarian
            $trashedKategoris = $query->get();

            return response()->json([
                'message' => 'Succes',
                'data' => $trashedKategoris
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }
}
