<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller;
use App\Exports\KaryawanExport;
use App\Imports\KaryawanImport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{

    public function index()
    {
        // Mengambil data karyawan yang role-nya bukan "manager"
        $karyawan = User::where('role', '!=', 'manager')->get();

        // Mengembalikan response JSON dengan data karyawan
        return response()->json($karyawan, 200);
    }

    // Method untuk mengimpor karyawan (seperti yang sudah dibuat sebelumnya)
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        Excel::import(new KaryawanImport, $request->file('file'));

        return response()->json(['message' => 'Data karyawan berhasil diimpor']);
    }
    

    // Method untuk mengekspor data karyawan
    public function export()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }

    public function destroy($id)
    {
        // Mencari karyawan berdasarkan ID
        $karyawan = User::find($id);

        // Jika data karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json([
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        // Menghapus data karyawan
        $karyawan->delete();

        // Mengembalikan response sukses
        return response()->json([
            'message' => 'Data karyawan berhasil dihapus.'
        ], 200);
    }
}
