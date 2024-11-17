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
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
            'email' => $row['email'],
            'nama' => $row['nama'],
            'no_telp'=>$row['no_telp'],
            'alamat'=>$row['alamat'],
            'role' => 'karyawan',
        ]);
    }
}
