<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BedController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $bangsalFilter = $request->query('bangsal');

            $query = Bed::query();

            if ($search) {
                $query->where('bed', 'like', "%$search%");
            }

            if ($bangsalFilter) {
                $query->where('bangsal', $bangsalFilter);
            }

            // Pagination
            $bed = $query->orderBy('bangsal')->paginate(20);

            return response()->json([
                'data' => $bed
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bed' => 'required|string|max:200|unique:bed,bed',
            'bangsal' => 'required|string|exists:bangsal,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $bed = Bed::create([
                'bed' => $request->bed,
                'bangsal' => $request->bangsal,
            ]);

            return response()->json([
                'message' => 'Bed created successfully',
                'data' => $bed
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
            'bed' => 'required|string|max:200|unique:bed,bed' . $id,
            'bangsal' => 'required|string|exists:bangsal,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        try {
            $bed = Bed::where('id', $id)->first();

            if (!$bed) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $bed->update([
                'bed' => $request->bed,
                'bangsal' => $request->bangsal,
            ]);

            return response()->json([
                'message' => 'Bed edit successfully',
                'data' => $bed
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server ' . $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $bed = Bed::find($id);

            if (!$bed) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $bed->delete();
            return response()->json([
                'message' => 'Bed deleted successfully'
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
            $bed = Bed::onlyTrashed()->find($id);

            if (!$bed) {
                return response()->json([
                    'message' => 'Data tidak ditemukan dalam sampah'
                ], 404);
            }

            $bed->restore();

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
