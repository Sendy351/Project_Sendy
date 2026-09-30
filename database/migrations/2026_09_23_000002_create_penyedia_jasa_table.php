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
        Schema::create('penyedia_jasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->unique()->constrained('pengguna')->onDelete('cascade');
            $table->string('nama');
            $table->string('telepon');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('aktif');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_jasa');
    }
};
