<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Kolam;
use Illuminate\Http\Request;

class KolamController extends Controller
{
    public function index()
    {
        return response()->json(Kolam::all());
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kolam' => 'required|string',
            'deskripsi' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'total_ikan' => 'required|integer',
            'total_pakan' => 'required|integer',
        ]);
        
        // Membuat entitas Kolam baru berdasarkan data request
        $kolam = Kolam::create($request->all());
        
        // Mengembalikan response JSON
        return response()->json($kolam, 201);
    }

    public function show($id)
    {
        $kolam = Kolam::find($id);
        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }
        return response()->json($kolam);
    }

    public function update(Request $request, $id)
    {
        $kolam = Kolam::find($id);
        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_kolam' => 'string',
            'deskripsi' => 'string',
            'jenis_kelamin' => 'string',
            'total_ikan' => 'integer',
            'total_pakan' => 'integer',
        ]);

        $kolam->update($request->all());
        return response()->json($kolam);
    }

    public function destroy($id)
    {
        $kolam = Kolam::find($id);
        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }

        $kolam->delete();
        return response()->json(['message' => 'Kolam berhasil dihapus.']);
    }
}
