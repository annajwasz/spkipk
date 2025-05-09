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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('noreg_kipk');
            $table->string('nama');
            $table->string('NIM');
            $table->foreignId('jurusan_id')->constrained('jurusans')->cascadeOnDelete();
            $table->foreignId('prodi_id')->constrained('prodis')->cascadeOnDelete();
            $table->string('akreditasi');
            $table->string('angkatan');
            $table->string('jalur_masuk');
            $table->string('ponsel');
            $table->string('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
