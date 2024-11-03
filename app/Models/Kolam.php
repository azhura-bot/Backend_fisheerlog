<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kolam extends Model
{

    protected $table = 'kolam';

    protected $fillable = ['nama_kolam', 'deskripsi', 'jenis_kelamin', 'total_ikan', 'total_pakan'];

    public function pembelianPakan()
    {
        return $this->hasMany(PembelianPakan::class);
    }

    public function penjualanIkan()
    {
        return $this->hasMany(PenjualanIkan::class);
    }
}
