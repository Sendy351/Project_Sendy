<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Simpan data gambar chat juga di database (selain file di storage/app/private/chat).
 * Hanya menambah 1 kolom di tabel pesan_chat; tabel lain tidak diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'])) {
            // MEDIUMBLOB = maks 16 MB (BLOB biasa cuma 64 KB, kekecilan untuk foto)
            DB::statement('ALTER TABLE `pesan_chat` ADD `foto_data` MEDIUMBLOB NULL AFTER `foto_path`');
        } else {
            Schema::table('pesan_chat', function (Blueprint $table) {
                $table->binary('foto_data')->nullable();
            });
        }

        // Salin foto yang sudah terkirim sebelumnya ke kolom baru
        DB::table('pesan_chat')
            ->whereNotNull('foto_path')
            ->whereNull('foto_data')
            ->orderBy('id')
            ->select(['id', 'foto_path'])
            ->each(function ($row) {
                if (Storage::disk('local')->exists($row->foto_path)) {
                    DB::table('pesan_chat')->where('id', $row->id)->update([
                        'foto_data' => Storage::disk('local')->get($row->foto_path),
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('pesan_chat', function (Blueprint $table) {
            $table->dropColumn('foto_data');
        });
    }
};
