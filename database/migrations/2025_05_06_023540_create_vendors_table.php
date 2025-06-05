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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->year('tahun_berdiri')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('ijin_usaha')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nik')->nullable();

            // Bank
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama_bank')->nullable();
            $table->string('alamat_bank')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('kode_bank')->nullable();

            // Kontak Utama
            $table->string('nama_kontak_utama')->nullable();
            $table->string('posisi_kontak_utama')->nullable();
            $table->string('email_kontak_utama')->nullable();
            $table->string('hp_kontak_utama')->nullable();

            // Kontak Keuangan
            $table->string('nama_kontak_keuangan')->nullable();
            $table->string('posisi_kontak_keuangan')->nullable();
            $table->string('email_kontak_keuangan')->nullable();
            $table->string('hp_kontak_keuangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
