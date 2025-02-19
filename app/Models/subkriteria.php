<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    
    protected $table = 'subkriterias'; //soalnya buatnya manual
    protected $guarded = [];

    // protected $table = 'subkriterias';
    
    // protected $fillable = [
    //     'kriteria_id',
    //     'nama',
    //     'deskripsi',
    //     'prioritas',
    //     'bobot'
    // ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}