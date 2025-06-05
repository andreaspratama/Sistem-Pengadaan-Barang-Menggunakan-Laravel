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
        Schema::create('perintahorder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perintahorder_id')->constrained()->onDelete('cascade');
            $table->foreignId('pengadaan_item_id')->constrained()->onDelete('cascade');
            $table->string('rab')->nullable();
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perintahorder_items');
    }
};
