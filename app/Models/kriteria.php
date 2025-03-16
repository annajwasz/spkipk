<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'prioritas',
        'bobot'
    ];

    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Tambahkan event saving untuk mengatur bobot awal
        static::saving(function ($kriteria) {
            if (is_null($kriteria->bobot)) {
                $kriteria->bobot = 0;
            }
        });

        static::saved(function ($kriteria) {
            // Hitung ulang bobot untuk semua kriteria
            $allKriteria = static::orderBy('prioritas')->get();
            $totalKriteria = $allKriteria->count();

            DB::beginTransaction();
            try {
                foreach ($allKriteria as $k) {
                    $bobot = static::hitungBobot($k->prioritas, $totalKriteria);
                    
                    DB::table('kriterias')
                        ->where('id', $k->id)
                        ->update(['bobot' => $bobot]);

                    // Update bobot subkriteria yang terkait
                    $subkriterias = SubKriteria::where('kriteria_id', $k->id)
                        ->orderBy('prioritas')
                        ->get();
                    
                    if ($subkriterias->count() > 0) {
                        foreach ($subkriterias as $sub) {
                            $totalSub = $subkriterias->count();
                            $subBobot = SubKriteria::hitungBobot($sub->prioritas, $totalSub, $bobot);
                            
                            DB::table('subkriterias')
                                ->where('id', $sub->id)
                                ->update(['bobot' => $subBobot]);
                        }
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }

    // Helper function untuk menghitung bobot
    public static function hitungBobot($prioritas, $total)
    {
        $bobot = 0;
        for ($i = $prioritas; $i <= $total; $i++) {
            $bobot += (1 / $i);
        }
        return $bobot / $total;
    }
}
