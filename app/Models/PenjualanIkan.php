<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanIkan extends Model
{
    protected $fillable = ['nama_ikan', 'deskripsi', 'kolam_id', 'jumlah_penjualan', 'tanggal_penjualan'];

    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
}
