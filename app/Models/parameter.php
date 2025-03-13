<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class parameter extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $appends = [
        'berkas_kip_url',
        'berkas_dtks_url',
        'berkas_1_url',
        'berkas_2_url',
        'berkas_3_url',
        'bukti_wafat_ayah_url',
        'bukti_wafat_ibu_url',
    ];
    
    protected $fillable = [
        'mahasiswa_id',
        'kepemilikan_kip',
        'berkas_kip',
        'terdata_dtks',
        'berkas_dtks',
        'tingkatan_desil',
        'berkas_1',
        'berkas_2',
        'berkas_3',
        'status_ayah',
        'bukti_wafat_ayah',
        'status_ibu',
        'bukti_wafat_ibu',
        'status',
        'alasan_tidak_valid',
    ];
    
    public function getBerkasKipUrlAttribute()
    {
        return $this->berkas_kip ? asset('berkas/' . $this->berkas_kip) : null;
    }
    
    public function getBerkasDtksUrlAttribute()
    {
        return $this->berkas_dtks ? asset('berkas/' . $this->berkas_dtks) : null;
    }
    
    public function getBerkas1UrlAttribute()
    {
        return $this->berkas_1 ? asset('berkas/' . $this->berkas_1) : null;
    }
    
    public function getBerkas2UrlAttribute()
    {
        return $this->berkas_2 ? asset('berkas/' . $this->berkas_2) : null;
    }
    
    public function getBerkas3UrlAttribute()
    {
        return $this->berkas_3 ? asset('berkas/' . $this->berkas_3) : null;
    }
    
    public function getBuktiWafatAyahUrlAttribute()
    {
        return $this->bukti_wafat_ayah ? asset('berkas/' . $this->bukti_wafat_ayah) : null;
    }
    
    public function getBuktiWafatIbuUrlAttribute()
    {
        return $this->bukti_wafat_ibu ? asset('berkas/' . $this->bukti_wafat_ibu) : null;
    }
   
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($parameter) {
            // Tentukan status orang tua berdasarkan status ayah dan ibu
            if ($parameter->status_ayah === 'Wafat' && $parameter->status_ibu === 'Wafat') {
                $parameter->status_orang_tua = 'Kedua Orang Tua Wafat';
                $parameter->nilai_status_orang_tua = 0.35;
            } elseif ($parameter->status_ayah === 'Wafat' || $parameter->status_ibu === 'Wafat') {
                $parameter->status_orang_tua = 'Salah Satu Orang Tua Wafat';
                $parameter->nilai_status_orang_tua = 0.25;
            } else {
                $parameter->status_orang_tua = 'Kedua Orang Tua Masih Hidup';
                $parameter->nilai_status_orang_tua = 0.15;
            }

            // Hitung jumlah berkas yang diupload
            $berkasCount = 0;
            if (!empty($parameter->berkas_1)) $berkasCount++;
            if (!empty($parameter->berkas_2)) $berkasCount++;
            if (!empty($parameter->berkas_3)) $berkasCount++;

            // Tentukan kondisi ekonomi dan nilai berdasarkan jumlah berkas
            if ($berkasCount >= 3) {
                $parameter->kondisi_ekonomi = 'Sangat Kurang Mampu';
                $parameter->nilai_kondisi_ekonomi = 0.4;
            } elseif ($berkasCount >= 2) {
                $parameter->kondisi_ekonomi = 'Kurang Mampu';
                $parameter->nilai_kondisi_ekonomi = 0.3;
            } else {
                $parameter->kondisi_ekonomi = 'Cukup Mampu';
                $parameter->nilai_kondisi_ekonomi = 0.3;
            }

            // Hitung total nilai
            $totalNilai = 0;

            // Nilai dari Kepemilikan KIP
            if ($parameter->kepemilikan_kip === 'Memiliki KIP') {
                $totalNilai += 0.6;
            } else {
                $totalNilai += 0.4;
            }

            // Nilai dari Tingkatan Desil
            switch ($parameter->tingkatan_desil) {
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
            $totalNilai += $parameter->nilai_kondisi_ekonomi;

            // Tambahkan nilai status orang tua
            $totalNilai += $parameter->nilai_status_orang_tua;

            $parameter->total_nilai = $totalNilai;
        });
    }
}
