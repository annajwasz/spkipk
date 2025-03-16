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
        Schema::table('parameters', function (Blueprint $table) {
            $table->enum('kondisi_ekonomi', [
                'Sangat Kurang Mampu', 
                'Kurang Mampu', 
                'Cukup Mampu', 
                'Tidak Menerima Bantuan'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->enum('kondisi_ekonomi', [
                'Sangat Kurang Mampu', 
                'Kurang Mampu', 
                'Cukup Mampu'
            ])->change();
        });
    }
};
