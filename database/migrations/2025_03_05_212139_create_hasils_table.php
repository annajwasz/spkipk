<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade'); // Relasi ke tabel mahasiswa
            $table->decimal('total_bobot', 5, 2); // Skor akhir hasil perhitungan SMARTER
            $table->enum('status', ['Layak','Dipertimbangkan', 'Tidak Layak'])->default('Tidak Layak'); // Status keputusan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasils');
    }
};
