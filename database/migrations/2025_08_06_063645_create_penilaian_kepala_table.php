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
        Schema::create('penilaian_kepala', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasi_id')->constrained('users')->onDelete('cascade');
            $table->integer('tahun');
            $table->string('triwulan', 10); // I, II, III, IV
            $table->integer('rating'); // 1-3 sesuai sistem rating
            $table->text('komentar');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // ID Kepala yang menilai
            $table->timestamps();
            
            // Satu Kasi hanya bisa dinilai sekali per periode
            $table->unique(['kasi_id', 'tahun', 'triwulan']);
            
            // Index untuk performa query
            $table->index(['kasi_id', 'tahun', 'triwulan']);
            $table->index(['created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kepala');
    }
};
