<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PembelianPakan;
use App\Models\Kolam;
use Illuminate\Http\Request;

class PembelianPakanController extends Controller
{
    public function index()
    {
        $pembelianPakan = PembelianPakan::with('kolam')->get();
        return response()->json($pembelianPakan);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_pakan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'nama_kolam' => 'required|string',
            'jumlah_pembelian' => 'required|string',
        ]);

        $kolam = Kolam::where('nama_kolam', $request->nama_kolam)->first();

        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }

        $kolam->total_pakan += $request->jumlah_pembelian;
        $kolam->save();

        $pembelian = PembelianPakan::create([
            'nama_pakan' => $request->nama_pakan,
            'deskripsi' => $request->deskripsi,
            'kolam_id' => $kolam->id,
            'jumlah_pembelian' => $request->jumlah_pembelian,
        ]);

        return response()->json($pembelian, 201);
    }

    public function show($id)
    {
        $pembelian = PembelianPakan::with('kolam')->find($id); // Eager load kolam
        if (!$pembelian) {
            return response()->json(['error' => 'Pembelian pakan tidak ditemukan.'], 404);
        }
        return response()->json($pembelian);
    }


    public function update(Request $request, $id)
    {
        $pembelian = PembelianPakan::find($id);
        if (!$pembelian) {
            return response()->json(['error' => 'Pembelian pakan tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_pakan' => 'string',
            'deskripsi' => 'string',
            'nama_kolam' => 'string',
            'jumlah_pembelian' => 'string',
        ]);

        $kolam = Kolam::find($pembelian->kolam_id);
        if ($kolam) {
            $kolam->total_pakan -= $pembelian->jumlah_pembelian; // Kembalikan jumlah pakan sebelumnya
            $kolam->total_pakan += $request->jumlah_pembelian; // Hitung pakan baru
            $kolam->save();
        }

        $pembelian->update($request->all());
        return response()->json($pembelian);
    }

    public function destroy($id)
    {
        $pembelian = PembelianPakan::find($id);
        if (!$pembelian) {
            return response()->json(['error' => 'Pembelian pakan tidak ditemukan.'], 404);
        }

        $kolam = Kolam::find($pembelian->kolam_id);
        if ($kolam) {
            $kolam->total_pakan -= $pembelian->jumlah_pembelian; // Kembalikan jumlah pakan
            $kolam->save();
        }

        $pembelian->delete();
        return response()->json(['message' => 'Pembelian pakan berhasil dihapus.']);
    }
}
