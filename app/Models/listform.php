<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listform extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'nilai_kepemilikan_kip' => 'decimal:7',
        'nilai_tingkatan_desil' => 'decimal:7',
        'nilai_kondisi_ekonomi' => 'decimal:7',
        'total_nilai' => 'decimal:7',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($listform) {
            // Hitung jumlah berkas yang diupload
            $berkasCount = 0;
            if (!empty($listform->berkas_sktm)) $berkasCount++;
            if (!empty($listform->berkas_ppke)) $berkasCount++;
            if (!empty($listform->berkas_pmk)) $berkasCount++;
            if (!empty($listform->berkas_pkh)) $berkasCount++;
            if (!empty($listform->berkas_kks)) $berkasCount++;

            // Tentukan kondisi ekonomi dan nilai berdasarkan jumlah berkas
            if ($berkasCount >= 4) {
                $listform->kondisi_ekonomi = 'Sangat Kurang Mampu';
                $listform->nilai_kondisi_ekonomi = 0.4;
            } elseif ($berkasCount >= 2) {
                $listform->kondisi_ekonomi = 'Kurang Mampu';
                $listform->nilai_kondisi_ekonomi = 0.3;
            } else {
                $listform->kondisi_ekonomi = 'Cukup Mampu';
                $listform->nilai_kondisi_ekonomi = 0.3;
            }

            // Hitung total nilai
            $totalNilai = 0;

            // Nilai dari Kepemilikan KIP
            if ($listform->kepemilikan_kip === 'Memiliki KIP') {
                $totalNilai += 0.6;
            } else {
                $totalNilai += 0.4;
            }

            // Nilai dari Tingkatan Desil
            switch ($listform->tingkatan_desil) {
                case 'Desil 1':
                    $totalNilai += 0.35;
                    break;
                case 'Desil 2':
                    $totalNilai += 0.25;
                    break;
                case 'Desil 3':
                    $totalNilai += 0.20;
                    break;
                case 'Desil 4':
                    $totalNilai += 0.15;
                    break;
                case 'Desil 5':
                    $totalNilai += 0.05;
                    break;
            }

            // Tambahkan nilai kondisi ekonomi
            $totalNilai += $listform->nilai_kondisi_ekonomi;

            $listform->total_nilai = $totalNilai;
        });
    }
}
