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
        Schema::create('pengadaan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('type');
            $table->string('merk')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('ukuran')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('rab')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status_finance')->default('pending');
            $table->string('catatan_finance')->nullable();
            $table->string('status_direktur')->default('pending');
            $table->string('catatan_direktur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_items');
    }
};
