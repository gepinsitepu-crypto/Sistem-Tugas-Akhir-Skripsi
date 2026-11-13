<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ruang_sidang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruangan');
            $table->string('nama_gedung');
            $table->integer('kapasitas');
            $table->text('fasilitas')->nullable();
            $table->string('status_ruangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang_sidangs');
    }
};
