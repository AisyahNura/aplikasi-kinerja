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
        Schema::create('komentar_kepala', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->string('triwulan');
            $table->text('komentar');
            $table->timestamps();
            
            $table->unique(['tahun', 'triwulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_kepala');
    }
};
