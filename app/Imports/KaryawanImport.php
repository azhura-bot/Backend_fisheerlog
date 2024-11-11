<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'username' => $row['username'],   // Pastikan header di Excel sama persis
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'role' => 'karyawan',
        ]);
    }
}
