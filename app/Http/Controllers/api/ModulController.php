<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Modul::all();
        return response()->json($modules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|mimes:pdf|max:10240', // Validasi hanya PDF dengan maksimal ukuran 10MB
        ]);
    
        $module = new Modul();
        $module->judul = $request->judul;
        $module->deskripsi = $request->deskripsi;
    
        // Simpan gambar di public/images
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $module->image_path = 'images/' . $imageName;
        }
    
        // Simpan file PDF di public/modul
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            // Validasi bahwa file harus PDF
            if ($file->getClientOriginalExtension() !== 'pdf') {
                return response()->json(['error' => 'Hanya file PDF yang diizinkan.'], 422);
            }
    
            $file->move(public_path('modul'), $fileName);
            $module->file_path = 'modul/' . $fileName;
        }
    
        $module->save();
    
        return response()->json($module);
    }
    
    public function download($id)
    {
        $module = Modul::findOrFail($id);
    
        if (!$module->file_path || !file_exists(public_path($module->file_path))) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }
    
        return response()->download(public_path($module->file_path));
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $module = Modul::find($id);
        return response()->json($module);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $module = Modul::find($id);
        $module->judul = $request->judul;
        $module->deskripsi = $request->deskripsi;

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($module->image_path && file_exists(public_path($module->image_path))) {
                unlink(public_path($module->image_path)); // Hapus gambar lama
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $module->image_path = 'images/' . $imageName;
        }

        // Update file modul jika ada file baru
        if ($request->hasFile('file')) {
            if ($module->file_path && file_exists(public_path($module->file_path))) {
                unlink(public_path($module->file_path)); // Hapus file modul lama
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('modul'), $fileName);
            $module->file_path = 'modul/' . $fileName;
        }

        $module->save();
        return response()->json($module);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $module = Modul::findOrFail($id);

        // Hapus gambar dan file modul jika ada
        if ($module->image_path && file_exists(public_path($module->image_path))) {
            unlink(public_path($module->image_path));
        }
        if ($module->file_path && file_exists(public_path($module->file_path))) {
            unlink(public_path($module->file_path));
        }

        $module->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
