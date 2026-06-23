<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('no_peserta');         // MA 1001
            $table->string('nama');
            $table->string('asal_sekolah');
            $table->string('mapel');              // MATEMATIKA, B.INGGRIS, dll
            $table->string('tingkat');            // TK, SD, SMP
            $table->string('kelas')->nullable();  // 1,2,3,...
            $table->string('ruang')->nullable();  // Ruang 1, Ruang 2
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
