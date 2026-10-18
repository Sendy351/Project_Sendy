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
        Schema::create('permintaan_jasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->foreignId('jasa_id')->constrained('jasa')->onDelete('cascade');
            $table->foreignId('penyedia_id')->nullable()->constrained('penyedia_jasa')->nullOnDelete();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi')->nullable();
            $table->dateTime('jadwal')->nullable();
            $table->string('status')->default('menunggu'); // 'menunggu', 'diambil', 'selesai', 'dibatalkan'
            $table->decimal('total_harga', 12, 2)->default(0.00);
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_jasa');
    }
};
