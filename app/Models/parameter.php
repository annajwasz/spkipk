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
        'kondisi_ekonomi',
        'nilai_kondisi_ekonomi',
        'status_orang_tua',
        'nilai_status_orang_tua',
        'total_nilai',
        'hasil'
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
            // Ambil semua kriteria dan urutkan berdasarkan prioritas
            $kriterias = Kriteria::orderBy('prioritas')->get();
            $totalNilai = 0;

            foreach ($kriterias as $kriteria) {
                switch ($kriteria->nama) {
                    case 'Kepemilikan KIP':
                        // Ambil SubKriteria berdasarkan kepemilikan KIP
                        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
                            ->where('nama', $parameter->kepemilikan_kip)
                            ->first();
                        if ($subKriteria) {
                            $totalNilai += $subKriteria->bobot;
                        }
                        break;

                    case 'Tingkatan Desil':
                        // Ambil SubKriteria berdasarkan tingkatan desil
                        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
                            ->where('nama', $parameter->tingkatan_desil)
                            ->first();
                        if ($subKriteria) {
                            $totalNilai += $subKriteria->bobot;
                        }
                        break;

                    case 'Kondisi Ekonomi':
            // Hitung jumlah berkas yang diupload
            $berkasCount = 0;
            if (!empty($parameter->berkas_1)) $berkasCount++;
            if (!empty($parameter->berkas_2)) $berkasCount++;
            if (!empty($parameter->berkas_3)) $berkasCount++;

                        // Tentukan kondisi ekonomi berdasarkan jumlah berkas
                        if ($berkasCount === 0) {
                            $kondisiEkonomi = 'Tidak Menerima Bantuan';
                        } elseif ($berkasCount >= 3) {
                            $kondisiEkonomi = 'Sangat Kurang Mampu';
                        } elseif ($berkasCount === 2) {
                            $kondisiEkonomi = 'Kurang Mampu';
            } else {
                            $kondisiEkonomi = 'Cukup Mampu';
                        }

                        // Set kondisi ekonomi
                        $parameter->kondisi_ekonomi = $kondisiEkonomi;

                        // Ambil SubKriteria berdasarkan kondisi ekonomi
                        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
                            ->where('nama', $kondisiEkonomi)
                            ->first();
                        if ($subKriteria) {
                            $totalNilai += $subKriteria->bobot;
                        }
                        break;

                    case 'Status Orang Tua':
                        // Tentukan status orang tua
                        if ($parameter->status_ayah === 'Wafat' && $parameter->status_ibu === 'Wafat') {
                            $statusOrangTua = 'Kedua Orang Tua Wafat';
                        } elseif ($parameter->status_ayah === 'Wafat' || $parameter->status_ibu === 'Wafat') {
                            $statusOrangTua = 'Salah Satu Orang Tua Wafat';
            } else {
                            $statusOrangTua = 'Kedua Orang Tua Masih Hidup';
                        }

                        // Set status orang tua
                        $parameter->status_orang_tua = $statusOrangTua;

                        // Ambil SubKriteria berdasarkan status orang tua
                        $subKriteria = SubKriteria::where('kriteria_id', $kriteria->id)
                            ->where('nama', $statusOrangTua)
                            ->first();
                        if ($subKriteria) {
                            $totalNilai += $subKriteria->bobot;
                        }
                    break;
                }
            }

            $parameter->total_nilai = $totalNilai;

            // // Tentukan hasil berdasarkan total nilai ini kayanya engga dipake deh
            // if ($totalNilai >= 0.75) {
            //     $parameter->hasil = 'Layak';
            // } elseif ($totalNilai >= 0.5) {
            //     $parameter->hasil = 'Dipertimbangkan';
            // } else {
            //     $parameter->hasil = 'Tidak Layak';
            // }
        });
    }
}
