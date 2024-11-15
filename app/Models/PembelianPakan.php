<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianPakan extends Model
{
    protected $table = 'pembelian_pakan';
    
    protected $fillable = ['nama_pakan', 'deskripsi', 'kolam_id', 'jumlah_pembelian'];

    public function kolam()
    {
        return $this->belongsTo(Kolam::class);
    }
}

