<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_Task extends Model
{
    //
    use HasFactory;

    protected $table = 'daily_task';

    protected $fillable = [
        'nama_task',
        'deskripsi',
        'status',
        'manager_id',
        'karyawan_username',
        'due_date',
        'completed',
    ];

    // Relasi dengan User
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_username', 'username');
    }

    // Relasi ke user (manager)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}