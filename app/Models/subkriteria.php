<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SubKriteria extends Model
{
    use HasFactory;
    
    protected $table = 'subkriterias'; //soalnya buatnya manual
    protected $guarded = [];

    protected $fillable = [
        'kriteria_id',
        'nama',
        'deskripsi',
        'prioritas',
        'bobot'
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Tambahkan event saving untuk mengatur bobot awal
        static::saving(function ($subKriteria) {
            if (is_null($subKriteria->bobot)) {
                $subKriteria->bobot = 0;
            }
        });

        static::saved(function ($subKriteria) {
            // Hitung ulang bobot untuk semua subkriteria dalam kriteria yang sama
            $kriteria = Kriteria::find($subKriteria->kriteria_id);
            if (!$kriteria) return;

            $allSubKriteria = static::where('kriteria_id', $subKriteria->kriteria_id)
                                  ->orderBy('prioritas')
                                  ->get();
            $totalSubKriteria = $allSubKriteria->count();

            DB::beginTransaction();
            try {
                foreach ($allSubKriteria as $sk) {
                    $subBobot = static::hitungBobot($sk->prioritas, $totalSubKriteria, $kriteria->bobot);

                    DB::table('subkriterias')
                        ->where('id', $sk->id)
                        ->update(['bobot' => $subBobot]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }

    // Helper function untuk menghitung bobot
    public static function hitungBobot($prioritas, $total, $bobotKriteria)
    {
        $bobot = 0;
        for ($i = $prioritas; $i <= $total; $i++) {
            $bobot += (1 / $i);
        }
        return ($bobot / $total) * $bobotKriteria;
    }
}