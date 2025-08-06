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
        Schema::create('realisasi_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('tugas_id');
            $table->integer('tahun');
            $table->string('triwulan', 10); // I, II, III, IV
            $table->integer('target_kuantitas');
            $table->integer('realisasi_kuantitas');
            $table->integer('target_waktu');
            $table->integer('realisasi_waktu');
            $table->integer('kualitas');
            $table->text('link_bukti')->nullable();
            $table->enum('status', ['draft', 'dikirim', 'verif', 'revisi'])->default('draft');
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['user_id', 'tahun', 'triwulan']);
            $table->index(['tugas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_kinerja');
    }
};
