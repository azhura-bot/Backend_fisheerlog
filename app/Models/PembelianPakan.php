<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianPakan extends Model
{
    protected $fillable = ['nama_pakan', 'deskripsi', 'kolam_id', 'jumlah_pembelian', 'tanggal_pembelian'];

    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
}

