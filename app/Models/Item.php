<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Field yang bisa diisi (biar aman dari mass-assignment)
    protected $fillable = [
        'name',
        'description',
    ];
}
