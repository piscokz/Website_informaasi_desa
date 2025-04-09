<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $casts = [
        'tanggal' => 'date',
    ];    
    protected $table = 'posts';
    protected $primaryKey = 'id_berita';

    protected $fillable = [
        'judul',
        'isi',
        'thumbnail',
        'tanggal',
    ];

    public $timestamps = true;
}
