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
        Schema::table('pengadaan_items', function (Blueprint $table) {
            $table->string('judul_buku')->nullable();
            $table->string('isbn')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('kelas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengadaan_items', function (Blueprint $table) {
            //
        });
    }
};
