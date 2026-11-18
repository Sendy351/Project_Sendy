<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel BARU untuk chat in-app per pesanan (teks + foto).
 * Tidak mengubah tabel lain yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignId('pengirim_id')->constrained('pengguna')->onDelete('cascade');
            $table->text('isi')->nullable();          // teks pesan / caption foto
            $table->string('foto_path')->nullable();   // path di disk privat (storage/app/private/chat/...)
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();

            $table->index(['pesanan_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_chat');
    }
};
