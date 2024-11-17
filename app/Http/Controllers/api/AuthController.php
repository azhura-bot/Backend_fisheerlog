<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Fungsi untuk membuat user dengan URL gambar
    private function createUser($validated, $role, $imageUrl = null)
    {
        return User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'image_path' => $imageUrl,
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);
    }

    // Fungsi untuk menghasilkan token autentikasi
    private function generateToken($user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    // Register user dengan role 'karyawan'
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
            'nama' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Maksimal 2 MB
        ]);

        $role = 'karyawan';
        $imageUrl = null;

        // Memproses upload gambar jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $imageName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('assets/images'), $imageName);
            $imagePath = 'assets/images/' . $imageName;
            $imageUrl = url($imagePath);
        }

        // Membuat user dengan URL gambar
        $user = $this->createUser($validated, $role, $imageUrl);

        if (!$user) {
            return response()->json(['message' => 'Failed to register karyawan'], 500);
        }

        $token = $this->generateToken($user);

        return response()->json([
            'message' => 'Karyawan registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'alamat' => $user->alamat,
                'foto' => $user->image_path,
                'role' => $user->role,
            ]
        ], 201);
    }

    // Update user profile
    public function updateUser(Request $request, $id)
    {
        // Mencari user berdasarkan ID
        $user = User::find($id);

        // Jika user tidak ditemukan, kembalikan respon error
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validasi input request
        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'nama' => 'sometimes|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Pastikan format dan ukuran foto valid
        ]);

        // Update data pengguna, hanya mengganti yang ada di request
        $user->username = $validated['username'] ?? $user->username;
        $user->email = $validated['email'] ?? $user->email;
        $user->nama = $validated['nama'] ?? $user->nama;
        $user->no_telp = $validated['no_telp'] ?? $user->no_telp;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        // Memproses upload gambar jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $imageName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('assets/images'), $imageName);
            $imagePath = 'assets/images/' . $imageName;
            $imageUrl = url($imagePath);
            $user->image_path = $imageUrl;
        }

        // Menyimpan perubahan ke database
        $user->save();

        // Mengembalikan respon sukses
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
    }

    
    

    // Login user
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $this->generateToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'no_telp' => $user->no_telp,
                'alamat' => $user->alamat,
                'foto' => $user->image_path,
                'role' => $user->role,
            ]
        ], 200);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }

    // Register manager
    public function registerManager(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
            'nama' => 'required|string|max:255',
        ]);

        $role = 'manager';
        $user = $this->createUser($validated, $role);

        if (!$user) {
            return response()->json(['message' => 'Failed to register manager'], 500);
        }

        $token = $this->generateToken($user);

        return response()->json([
            'message' => 'Manager registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 201);
    }
}
