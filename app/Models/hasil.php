<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasil extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id', 'total_bobot', 'status'];

    public function mahasiswa()
    {
        return $this->belongsTo(mahasiswa::class);
    }
}
