<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'noreg_kipk',
        'nama',
        'NIM',
        'jurusan_id',
        'prodi_id',
        'akreditasi',
        'angkatan',
        'jalur_masuk',
        'ponsel',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function parameter()
    {
        return $this->hasOne(Parameter::class);
    }
}
