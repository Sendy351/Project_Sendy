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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('runner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('category'); // 'print_dokumen', 'titip_makanan', 'ambil_barang', 'lainnya'
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->decimal('item_price', 12, 2)->default(0.00); // estimasi talangan
            $table->decimal('tip_amount', 12, 2)->default(5000.00); // ongkos jasa runner
            $table->string('status')->default('open'); // 'open', 'taken', 'in_progress', 'delivered', 'completed', 'cancelled'
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
