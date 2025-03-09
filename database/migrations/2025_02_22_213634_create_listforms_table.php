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
        Schema::create('listforms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            
            // Untuk Kriteria 1: Kepemilikan KIP
            $table->enum('kepemilikan_kip', ['Memiliki KIP', 'Tidak Memiliki KIP']);
            
            // Untuk Kriteria 2: Tingkatan Desil
            $table->enum('tingkatan_desil', [
                'Desil 1', 
                'Desil 2', 
                'Desil 3', 
                'Desil 4', 
                'Desil 5'
            ]);
            
            // Untuk Kriteria 3: Kondisi Ekonomi
            $table->enum('kondisi_ekonomi', ['Sangat Kurang Mampu', 'Kurang Mampu', 'Cukup Mampu']);
            
            // Berkas untuk Kondisi Ekonomi
            $table->string('berkas_sktm')->nullable(); // Untuk semua kondisi
            $table->string('berkas_ppke')->nullable(); // Untuk Kurang Mampu & Sangat Kurang Mampu
            $table->string('berkas_pmk')->nullable();  // Untuk Kurang Mampu & Sangat Kurang Mampu
            $table->string('berkas_pkh')->nullable();  // Khusus Sangat Kurang Mampu
            $table->string('berkas_kks')->nullable();  // Khusus Sangat Kurang Mampu
            
            // Untuk menyimpan nilai perhitungan
            $table->decimal('nilai_kepemilikan_kip', 10, 7)->default(0);
            $table->decimal('nilai_tingkatan_desil', 10, 7)->default(0);
            $table->decimal('nilai_kondisi_ekonomi', 10, 7)->default(0);
            $table->decimal('total_nilai', 10, 7)->default(0);
            
            // Status form
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listforms');
    }
};
