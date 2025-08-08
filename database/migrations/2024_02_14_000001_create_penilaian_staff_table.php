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
        Schema::create('penilaian_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kasi_id')->constrained('users')->onDelete('cascade');
            $table->year('tahun');
            $table->enum('triwulan', ['I', 'II', 'III', 'IV']);
            $table->tinyInteger('rating')->comment('1=Di Bawah Ekspektasi, 2=Sesuai Ekspektasi, 3=Melebihi Ekspektasi');
            $table->text('komentar')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk memastikan tidak ada duplikat penilaian
            $table->unique(['staff_id', 'kasi_id', 'tahun', 'triwulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_staff');
    }
};
