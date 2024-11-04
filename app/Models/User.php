<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'username',      // Nama pengguna
        'email',     // Alamat email pengguna
        'password',  // Kata sandi pengguna
        'role',      // Role pengguna
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',       // Kata sandi yang disembunyikan saat diserialisasi
        'remember_token', // Token untuk mengingat sesi pengguna
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Mengkonversi ke tipe tanggal/waktu
    ];

    /**
     * The default attributes for the model.
     *
     * @var array<string, mixed>
     */
    // protected $attributes = [
    //     'role' => 'karyawan', // Set role default sebagai karyawan
    // ];
}