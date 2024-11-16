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
    // Fungsi untuk membuat user
    private function createUser($validated, $role)
    {
        // Cek apakah foto diberikan dalam base64
        $foto = $validated['foto'] ?? null;

        if($foto && strpos($foto, 'data:image') === 0) {
            // Jika foto diberikan dalam base64, simpan sebagai string
        } else {
            // Jika tidak ada foto, gunakan foto default dari public/assets/images
            $foto = asset('assets/images/foto_profile.png');
        }

        return User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'foto' => $foto,
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
        // Validasi input yang diterima
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
            'nama' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $role = 'karyawan';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('foto_profile', 'public'); // Simpan foto ke folder foto_profile
        } else {
            $fotoPath = 'assets/images/foto_profile.png'; // Foto default jika tidak ada upload
        }
    
        // Membuat user baru
        $user = $this->createUser($validated, $role);

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
                'foto' => $user->foto,
                'role' => $user->role,
            ]
        ], 201);
    }

    // Update user
    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'nama' => 'sometimes|string|max:255',
            'no_telp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|string',
        ]);

        $user->username = $validated['username'] ?? $user->username;
        $user->email = $validated['email'] ?? $user->email;
        $user->nama = $validated['nama'] ?? $user->nama;
        $user->no_telp = $validated['no_telp'] ?? $user->no_telp;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        if (isset($validated['foto']) && !empty($validated['foto'])) {
            $user->foto = $validated['foto'];
        } elseif (empty($user->foto)) {
            $user->foto = asset('assets/images/foto_profile.png');
        }

        $user->save();

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

        $token = $user->createToken('auth_token')->plainTextToken;

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
                'foto' => $user->foto,
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
                'email' => $user->email,
                'role' => $user->role,
            ]
        ], 201);
    }
}
