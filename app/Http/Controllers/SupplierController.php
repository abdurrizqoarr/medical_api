<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Menambahkan pencarian berdasarkan kolom 'nama_suplier'
        if ($request->has('nama_suplier') && $request->nama_suplier != '') {
            $query->where('nama_suplier', 'like', '%' . $request->nama_suplier . '%');
        }

        $suppliers = $query->get();
        return response()->json($suppliers);
    }

    // Fungsi untuk menambahkan data supplier baru
    public function store(Request $request)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama_suplier' => 'required|string|max:255',
            'no_kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'nama_suplier.required' => 'Nama Supplier harus diisi.',
            'no_kontak.required' => 'Nomer Kontak harus diisi.',
            'alamat.required' => 'alamat harus diisi.',
            'string' => 'Tipe data tidak valid.',
            'nama_suplier.max' => 'Nama Supplier maksimal 255 karakter.',
            'no_kontak.max' => 'Nomer Kontak maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            // Membuat data supplier baru
            $supplier = Supplier::create([
                'nama_suplier' => $request->nama_suplier,
                'no_kontak' => $request->no_kontak,
                'alamat' => $request->alamat,
            ]);

            return response()->json($supplier, 201);  // Mengembalikan data dengan status 201 (created)
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk mendapatkan data supplier berdasarkan ID
    public function show($id)
    {
        try {
            // Mencari supplier berdasarkan ID
            $supplier = Supplier::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }

            return response()->json($supplier);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk mengupdate data supplier
    public function update(Request $request, $id)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama_suplier' => 'required|string|max:255',
            'no_kontak' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ], [
            'nama_suplier.required' => 'Nama Supplier harus diisi.',
            'no_kontak.required' => 'Nomer Kontak harus diisi.',
            'alamat.required' => 'alamat harus diisi.',
            'string' => 'Tipe data tidak valid.',
            'nama_suplier.max' => 'Nama Supplier maksimal 255 karakter.',
            'no_kontak.max' => 'Nomer Kontak maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            // Mencari supplier berdasarkan ID
            $supplier = Supplier::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }

            // Mengupdate data supplier
            $supplier->update([
                'nama_suplier' => $request->nama_suplier,
                'no_kontak' => $request->no_kontak,
                'alamat' => $request->alamat,
            ]);

            return response()->json($supplier);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk menghapus data supplier (soft delete)
    public function destroy($id)
    {
        try {
            // Mencari supplier berdasarkan ID
            $supplier = Supplier::find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }

            // Melakukan soft delete
            $supplier->delete();

            return response()->json(['message' => 'Supplier deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Fungsi untuk mengembalikan data yang telah dihapus (soft delete)
    public function restore($id)
    {
        try {
            // Mencari supplier yang sudah dihapus
            $supplier = Supplier::onlyTrashed()->find($id);

            // Jika data tidak ditemukan, kembalikan error
            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found or not deleted'], 404);
            }

            // Mengembalikan data yang telah dihapus
            $supplier->restore();

            return response()->json(['message' => 'Supplier restored successfully', 'supplier' => $supplier]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function trashed(Request $request)
    {
        try {
            $query = Supplier::onlyTrashed();  // Hanya mengambil data yang dihapus (soft deleted)

            if ($request->has('nama_suplier') && $request->nama_suplier != '') {
                $query->where('nama_suplier', 'like', '%' . $request->nama_suplier . '%');
            }

            // Ambil hasil pencarian
            $trashedSatuan = $query->get();

            return response()->json([
                'message' => 'Succes',
                'data' => $trashedSatuan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
