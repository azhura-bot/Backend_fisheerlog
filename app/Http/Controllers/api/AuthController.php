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
        return User::create([
            'username' => $validated['username'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'no_telp' => $validated['no_telp'],
            'alamat' => $validated['alamat'],
            'foto' => $validated['foto'],
            
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
        ]);
    
        // Menetapkan role sebagai 'manager' secara otomatis
        $role = 'karyawan';
    
        // Membuat user baru dengan role 'manager'
        $user = $this->createUser($validated, $role);
    
        // Jika pembuatan user gagal
        if (!$user) {
            return response()->json(['message' => 'Failed to register karyawan'], 500);
        }
    
        // Generate token untuk user yang baru dibuat
        $token = $this->generateToken($user);
    
        // Return response dengan token dan data user
        return response()->json([
            'message' => 'Manager registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama' => $user->nama,
                'email' => $user->email,
                'no_telp' => $user ->no_telp,
                'alamat' => $user ->alamat,
                'foto' => $user ->foto,
                'role' => $user->role,
            ]
        ], 201); // Status 201 menunjukkan resource baru berhasil dibuat
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
                'no_telp' => $user ->no_telp,
                'alamat' => $user ->alamat,
                'foto' => $user ->foto,
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
        // Validasi input yang diterima
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
        ]);
    
        // Menetapkan role sebagai 'manager' secara otomatis
        $role = 'manager';
    
        // Membuat user baru dengan role 'manager'
        $user = $this->createUser($validated, $role);
    
        // Jika pembuatan user gagal
        if (!$user) {
            return response()->json(['message' => 'Failed to register manager'], 500);
        }
    
        // Generate token untuk user yang baru dibuat
        $token = $this->generateToken($user);
    
        // Return response dengan token dan data user
        return response()->json([
            'message' => 'Manager registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role, // Akan otomatis 'manager'
            ]
        ], 201); // Status 201 menunjukkan resource baru berhasil dibuat
    }
    
}
