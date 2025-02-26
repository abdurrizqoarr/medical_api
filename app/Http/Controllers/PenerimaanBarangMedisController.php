<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DetailPenerimaanBarangMedis;
use App\Models\PenerimaanBarangMedis;
use App\Models\PengajuanBarangMedis;
use App\Models\StokBarangMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PenerimaanBarangMedisController extends Controller
{
    public function terimaBarang(Request $request, $noPengajuan)
    {
        $validate = Validator::make($request->all(), [
            'depo_penerima' => 'required|uuid|exists:depo_obat,id',
            'pegawai_penerima' => 'required|uuid|exists:pegawai,id',
            'rek_pebayaran' => 'nullable|string',
            'tanggal_jatuh_tempo' => 'required|date',
            'barang' => 'required|array',
            'barang.*.databarang' => 'required|uuid',
            'barang.*.jumlah' => 'required|integer|min:1',
            'barang.*.harga_terima' => 'required|numeric|min:0',
            'barang.*.presentase_diskon' => 'nullable|numeric|min:0|max:100',
            'barang.*.presentase_pajak' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()->all()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Cek apakah pengajuan valid
            $pengajuan = PengajuanBarangMedis::where('no_pegajuan', $noPengajuan)->where('status', 'PURCHASE ORDER')->firstOrFail();

            if ($pengajuan->status === "PURCHASE ORDER") {
                // Buat nomor penerimaan unik
                $noPenerimaan = 'TRM-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5));

                $totalSebelumPajak = 0;
                $totalSetelahPajak = 0;

                foreach ($request->barang as $item) {
                    $subtotal = $item['jumlah'] * $item['harga_terima'];
                    $pajak = ceil(($item['presentase_pajak'] / 100) * $subtotal); // Pajak dibulatkan ke atas
                    $totalItem = $subtotal + $pajak;

                    $totalSebelumPajak += $subtotal;
                    $totalSetelahPajak += $totalItem;
                }

                PenerimaanBarangMedis::create([
                    'no_penerimaan' => $noPenerimaan,
                    'no_pegajuan' => $noPengajuan,
                    'supplier' => $pengajuan->supplier,
                    'depo_penerima' => $request->depo_penerima,
                    'pegawai_penerima' => $request->pegawai_penerima,
                    'tanggal_penerimaan' => now(),
                    'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                    'total_sebelum_pajak' => $totalSebelumPajak,
                    'total_setelah_pajak' => $totalSetelahPajak,
                ]);

                foreach ($request->barang as $item) {
                    $subtotal = $item['jumlah'] * $item['harga_terima'];
                    $pajak = ceil(($item['presentase_pajak'] / 100) * $subtotal); // Pajak dibulatkan ke atas
                    $totalItem = $subtotal + $pajak;

                    $totalSebelumPajak += $subtotal;
                    $totalSetelahPajak += $totalItem;

                    DetailPenerimaanBarangMedis::create([
                        'no_penerimaan' => $noPenerimaan,
                        'databarang' => $item['databarang'],
                        'jumlah' => $item['jumlah'],
                        'harga_terima' => $item['harga_terima'],
                        'presentase_diskon' => $item['presentase_diskon'],
                        'total_harga_terima_sebelum_pajak' => $subtotal,
                        'presentase_pajak' => $item['presentase_pajak'],
                        'total_harga_pesan_setelah_pajak' => $totalItem,
                    ]);

                    $stok = StokBarangMedis::where('depo', $request->depo_penerima)
                        ->where('databarang', $item['databarang'])
                        ->first();

                    if ($stok) {
                        // Jika stok barang sudah ada, update jumlahnya
                        $stok->increment('jumlah_stok', $item['jumlah']);
                    } else {
                        // Jika stok belum ada, buat baru
                        StokBarangMedis::create([
                            'depo' => $request->depo_penerima,
                            'databarang' => $item['databarang'],
                            'jumlah_stok' => $item['jumlah'],
                        ]);
                    }

                    $barang = DataBarang::where('id', $item['databarang'])->first();

                    if ($barang) {
                        if ($item['harga_terima'] > $barang->h_dasar) {
                            $barang->update([
                                'h_dasar' => $item['harga_terima'],
                                'h_beli' => $item['harga_terima'] + ceil(($item['presentase_pajak'] / 100) * $item['harga_terima'])
                            ]);
                        }
                    }
                }

                $pengajuan->update(['status' => 'DITERIMA']);

                DB::commit();

                return response()->json(['message' => 'Barang berhasil diterima', 'no_penerimaan' => $noPenerimaan], 201);
            } else {
                return response()->json(['message' => 'Pengajuan Belum Diterima'], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
