<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jurusan_id',
        'akreditasi'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
} 