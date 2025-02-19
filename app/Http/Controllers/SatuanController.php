<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Satuan::query();

            // Jika ada parameter pencarian pada kolom satuan
            if ($request->has('search') && $request->search != '') {
                $query->where('satuan', 'like', '%' . $request->search . '%');
            }

            // Ambil hasil pencarian
            $satuans = $query->get();

            // Kembalikan response dalam format JSON
            return response()->json([
                'messages' => 'success',
                'data' => $satuans
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Terjadi kesalahan server ' . $th->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'satuan' => 'required|string|max:120|unique:satuan,satuan',
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
            $satuan = Satuan::create([
                'satuan' => $request->satuan,
            ]);

            return response()->json([
                'messages' => 'success',
                'data' => $satuan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    // Mengupdate data satuan
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'satuan' => 'required|string|max:120|unique:satuan,satuan,' . $id,
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
            $satuan = Satuan::find($id);

            if (!$satuan) {
                return response()->json(['message' => 'Satuan not found'], 404);
            }

            // Update satuan
            $satuan->update([
                'satuan' => $request->satuan,
            ]);

            return response()->json([
                'messages' => 'success',
                'data' => $satuan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $satuan = Satuan::find($id);

            if (!$satuan) {
                return response()->json(['message' => 'Satuan not found'], 404);
            }

            // Soft delete satuan
            $satuan->delete();

            return response()->json([
                'messages' => 'success',
                'data' => $satuan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function trashed(Request $request)
    {
        try {
            $query = Satuan::onlyTrashed();  // Hanya mengambil data yang dihapus (soft deleted)

            if ($request->has('search') && $request->search != '') {
                $query->where('satuan', 'like', '%' . $request->search . '%');
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

    public function restore($id)
    {
        try {
            $satuan = Satuan::onlyTrashed()->find($id);

            if (!$satuan) {
                return response()->json(['message' => 'Satuan not found or not deleted'], 404);
            }

            $satuan->restore();

            return response()->json(['message' => 'success', 'data' => $satuan]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }
}
