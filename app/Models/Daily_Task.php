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
        'task_name', 
        'description', 
        'status', 
        'manager_id'
    ];
}
