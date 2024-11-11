<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanIkan;
use App\Models\Kolam;
use Illuminate\Http\Request;

class PenjualanIkanController extends Controller
{
    public function index()
    {
        return response()->json(PenjualanIkan::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ikan' => 'required|string',
            'deskripsi' => 'nullable|string',
            'nama_kolam' => 'required|string',
            'jumlah_penjualan' => 'required|integer',
            'tanggal_penjualan' => 'required|date',
        ]);

        $kolam = Kolam::where('nama_kolam', $request->nama_kolam)->first();

        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }

        if ($kolam->total_ikan < $request->jumlah_penjualan) {
            return response()->json(['error' => 'Jumlah ikan tidak mencukupi.'], 400);
        }

        $kolam->total_ikan -= $request->jumlah_penjualan;
        $kolam->save();

        $penjualan = PenjualanIkan::create([
            'nama_ikan' => $request->nama_ikan,
            'deskripsi' => $request->deskripsi,
            'kolam_id' => $kolam->id,
            'jumlah_penjualan' => $request->jumlah_penjualan,
            'tanggal_penjualan' => $request->tanggal_penjualan,
        ]);

        return response()->json($penjualan, 201);
    }

    public function show($id)
    {
        $penjualan = PenjualanIkan::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Penjualan ikan tidak ditemukan.'], 404);
        }
        return response()->json($penjualan);
    }

    public function update(Request $request, $id)
    {
        $penjualan = PenjualanIkan::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Penjualan ikan tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_ikan' => 'string',
            'deskripsi' => 'string',
            'nama_kolam' => 'string',
            'jumlah_penjualan' => 'integer',
            'tanggal_penjualan' => 'date',
        ]);

        $kolam = Kolam::find($penjualan->kolam_id);
        if ($kolam) {
            $kolam->total_ikan += $penjualan->jumlah_penjualan; // Kembalikan jumlah ikan sebelumnya
            $kolam->total_ikan -= $request->jumlah_penjualan; // Hitung ikan baru
            $kolam->save();
        }

        $penjualan->update($request->all());
        return response()->json($penjualan);
    }

    public function destroy($id)
    {
        $penjualan = PenjualanIkan::find($id);
        if (!$penjualan) {
            return response()->json(['error' => 'Penjualan ikan tidak ditemukan.'], 404);
        }

        $kolam = Kolam::find($penjualan->kolam_id);
        if ($kolam) {
            $kolam->total_ikan += $penjualan->jumlah_penjualan; // Kembalikan jumlah ikan
            $kolam->save();
        }

        $penjualan->delete();
        return response()->json(['message' => 'Penjualan ikan berhasil dihapus.']);
    }
}

