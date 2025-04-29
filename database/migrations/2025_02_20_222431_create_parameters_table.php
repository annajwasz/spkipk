<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();

            // Untuk Kriteria 1: Kepemilikan KIP
            $table->enum('kepemilikan_kip', ['Memiliki KIP', 'Tidak Memiliki KIP']);
            
            //bukti terdata di kip
            $table->string('berkas_kip')->nullable();
            
            //terdata di dtks
            $table->enum('terdata_dtks', ['Terdata', 'Tidak Terdata']);

            //bukti terdata di dtks
            $table->string('berkas_dtks')->nullable();
            
            // Untuk Kriteria 2: Tingkatan Desil
            $table->enum('tingkatan_desil', [
                'Desil 1', 
                'Desil 2', 
                'Desil 3', 
                'Desil 4', 
                'Desil 5'
            ]);
            
            // Untuk Kriteria 3: Kondisi Ekonomi
            $table->enum('kondisi_ekonomi', [
                'Sangat Kurang Mampu', 
                'Kurang Mampu', 
                'Cukup Mampu',
                'Tidak Menerima Bantuan'
            ]);
            
            // Berkas untuk Kondisi Ekonomi
            $table->string('berkas_1')->nullable(); // Untuk semua kondisi
            $table->string('berkas_2')->nullable(); // Untuk Kurang Mampu & Sangat Kurang Mampu
            $table->string('berkas_3')->nullable();  // Untuk Kurang Mampu & Sangat Kurang Mampu

            // Untuk Kriteria 4: Status Orang tua
            $table->enum('status_orang_tua', [
                'Kedua Orang Tua Wafat', 
                'Salah Satu Orang Tua Wafat', 
                'Kedua Orang Tua Masih Hidup'
            ]);
            
            // Detail status orang tua
            $table->enum('status_ayah', ['Hidup', 'Wafat'])->default('Hidup');
            $table->enum('status_ibu', ['Hidup', 'Wafat'])->default('Hidup');
            
            // Bukti kematian orang tua
            $table->string('bukti_wafat_ayah')->nullable();
            $table->string('bukti_wafat_ibu')->nullable();

            // Status form
            $table->enum('status', ['belum_validasi', 'valid','tidak_valid'])->default('belum_validasi');
            
            // Alasan tidak valid
            $table->text('alasan_tidak_valid')->nullable();

            // Untuk menyimpan nilai perhitungan
            $table->decimal('nilai_kepemilikan_kip', 10, 7)->default(0);
            $table->decimal('nilai_tingkatan_desil', 10, 7)->default(0);
            $table->decimal('nilai_kondisi_ekonomi', 10, 7)->default(0);
            $table->decimal('nilai_status_orang_tua', 10, 7)->default(0);
            $table->decimal('total_nilai', 10, 7)->default(0);
            
            // Hasil penilaian
            $table->enum('hasil', ['Layak', 'Dipertimbangkan', 'Tidak Layak'])->nullable();
            
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}; 