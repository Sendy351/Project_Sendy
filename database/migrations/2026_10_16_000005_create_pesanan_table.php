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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaan_id')->constrained('permintaan_jasa')->onDelete('cascade');
            $table->foreignId('penyedia_id')->constrained('penyedia_jasa')->onDelete('cascade');
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('status')->default('menunggu');
            $table->timestamp('diterima_pada')->nullable();
            $table->timestamp('dimulai_pada')->nullable();
            $table->timestamp('selesai_pada')->nullable();
            $table->decimal('total_harga', 12, 2);
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
