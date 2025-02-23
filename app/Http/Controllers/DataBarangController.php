<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataBarang;
use Illuminate\Http\Request;

class DataBarangController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');

            $query = DataBarang::query();

            // Pencarian dengan grouping
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
            $pasien = $query->orderBy('nama_brng')->paginate(10);

            return response()->json(['data' => $pasien], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }
}
