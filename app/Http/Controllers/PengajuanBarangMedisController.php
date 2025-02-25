<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPengajuanBarangMedis;
use App\Models\PengajuanBarangMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanBarangMedisController extends Controller
{
    public function createPengajuan(Request $request)
    {
        $request->validate([
            'supplier' => 'required|exists:supplier,id',
            'pegawai_pengaju' => 'required|exists:pegawai,id',
            'barang' => 'required|array',
            'barang.*.databarang' => 'required|exists:data_barang,id',
            'barang.*.jumlah' => 'required|integer|min:1',
            'barang.*.harga_pesan' => 'required|numeric|min:0',
            'barang.*.presentase_pajak' => 'numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();

            // Buat nomor pengajuan unik
            $noPengajuan = 'PJM-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5));

            // Hitung total harga sebelum dan setelah pajak
            $totalSebelumPajak = 0;
            $totalSetelahPajak = 0;

            foreach ($request->barang as $item) {
                $subtotal = $item['jumlah'] * $item['harga_pesan'];
                $pajak = ($item['presentase_pajak'] / 100) * $subtotal;
                $totalItem = $subtotal + $pajak;

                $totalSebelumPajak += $subtotal;
                $totalSetelahPajak += $totalItem;
            }

            // Simpan ke tabel pengajuan_barang_medis
            $pengajuan = PengajuanBarangMedis::create([
                'no_pegajuan' => $noPengajuan,
                'supplier' => $request->supplier,
                'pegawai_pengaju' => $request->pegawai_pengaju,
                'tanggal_pengajuan' => now(),
                'total_sebelum_pajak' => $totalSebelumPajak,
                'total_setelah_pajak' => $totalSetelahPajak,
                'status' => 'PENGAJUAN',
            ]);

            // Simpan ke tabel detail_pengajuan_barang_medis
            foreach ($request->barang as $item) {
                $subtotal = $item['jumlah'] * $item['harga_pesan'];
                $pajak = ($item['presentase_pajak'] / 100) * $subtotal;
                $totalItem = $subtotal + $pajak;

                DetailPengajuanBarangMedis::create([
                    'no_pegajuan' => $noPengajuan,
                    'databarang' => $item['databarang'],
                    'jumlah' => $item['jumlah'],
                    'harga_pesan' => $item['harga_pesan'],
                    'total_harga_pesan_sebelum_pajak' => $subtotal,
                    'presentase_pajak' => $item['presentase_pajak'],
                    'total_harga_pesan_setelah_pajak' => $totalItem,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pengajuan barang medis berhasil dibuat',
                'data' => $pengajuan
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ], 500);
        }
    }

    public function updatePengajuan(Request $request, $noPengajuan)
    {
        $request->validate([
            'supplier' => 'required|exists:supplier,id',
            'pegawai_pengaju' => 'required|exists:pegawai,id',
            'barang' => 'required|array',
            'barang.*.id' => 'nullable|exists:detail_pengajuan_barang_medis,id',
            'barang.*.databarang' => 'required|exists:data_barang,id',
            'barang.*.jumlah' => 'required|integer|min:1',
            'barang.*.harga_pesan' => 'required|numeric|min:0',
            'barang.*.presentase_pajak' => 'numeric|min:0|max:100'
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah pengajuan ada di database
            $pengajuan = PengajuanBarangMedis::where('no_pegajuan', $noPengajuan)->firstOrFail();

            // Jika status sudah "DITERIMA" atau "PURCHASE ORDER", tidak bisa diubah
            if (in_array($pengajuan->status, ['PURCHASE ORDER', 'DITERIMA'])) {
                return response()->json([
                    'message' => 'Pengajuan tidak dapat diubah karena sudah diproses.'
                ], 403);
            }

            // Hapus detail pengajuan lama sebelum update
            DetailPengajuanBarangMedis::where('no_pegajuan', $noPengajuan)->delete();

            // Hitung ulang total harga sebelum dan setelah pajak
            $totalSebelumPajak = 0;
            $totalSetelahPajak = 0;

            foreach ($request->barang as $item) {
                $subtotal = $item['jumlah'] * $item['harga_pesan'];
                $pajak = ($item['presentase_pajak'] / 100) * $subtotal;
                $totalItem = $subtotal + $pajak;

                $totalSebelumPajak += $subtotal;
                $totalSetelahPajak += $totalItem;
            }

            // Update data di tabel pengajuan_barang_medis
            $pengajuan->update([
                'supplier' => $request->supplier,
                'pegawai_pengaju' => $request->pegawai_pengaju,
                'total_sebelum_pajak' => $totalSebelumPajak,
                'total_setelah_pajak' => $totalSetelahPajak,
                'status' => 'PENGAJUAN'
            ]);

            // Simpan detail barang yang baru
            foreach ($request->barang as $item) {
                $subtotal = $item['jumlah'] * $item['harga_pesan'];
                $pajak = ($item['presentase_pajak'] / 100) * $subtotal;
                $totalItem = $subtotal + $pajak;

                DetailPengajuanBarangMedis::create([
                    'no_pegajuan' => $noPengajuan,
                    'databarang' => $item['databarang'],
                    'jumlah' => $item['jumlah'],
                    'harga_pesan' => $item['harga_pesan'],
                    'total_harga_pesan_sebelum_pajak' => $subtotal,
                    'presentase_pajak' => $item['presentase_pajak'],
                    'total_harga_pesan_setelah_pajak' => $totalItem,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pengajuan barang medis berhasil diperbarui',
                'data' => $pengajuan
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $th->getMessage()
            ], 500);
        }
    }
}
