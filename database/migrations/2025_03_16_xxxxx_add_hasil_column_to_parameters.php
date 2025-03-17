<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->enum('hasil', ['Layak', 'Dipertimbangkan', 'Tidak Layak'])->nullable()->after('total_nilai');
        });
    }

    public function down(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn('hasil');
        });
    }
}; 