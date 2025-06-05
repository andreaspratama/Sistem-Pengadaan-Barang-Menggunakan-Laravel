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
        Schema::create('perintahorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->foreignId('pengadaan_id')->constrained()->onDelete('cascade');
            $table->string('no_surat')->nullable();
            $table->string('nama_pemesan')->nullable();
            $table->string('alamat_pemesan')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('diskon')->nullable();
            $table->string('total')->nullable();
            $table->string('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perintahorders');
    }
};
