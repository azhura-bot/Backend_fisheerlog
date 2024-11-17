<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    /**
     * Mendapatkan koleksi data karyawan
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil data karyawan saja berdasarkan role
        return User::where('role', 'karyawan')->get(['username', 'nama', 'email', 'no_telp', 'alamat']);
    }

    /**
     * Mendefinisikan heading kolom untuk file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Username',
            'Nama',
            'Email',
            'No_Telp',
            'Alamat',
        ];
    }
}

