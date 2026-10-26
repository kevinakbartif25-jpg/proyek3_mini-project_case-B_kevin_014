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
        Schema::create('report_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Relawan / Koordinator
            $table->enum('status_sebelumnya', [
                'menunggu_peninjauan',
                'diverifikasi',
                'ditolak',
                'diteruskan',
                'selesai'
            ]);
            $table->enum('status_baru', [
                'menunggu_peninjauan',
                'diverifikasi',
                'ditolak',
                'diteruskan',
                'selesai'
            ]);
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_reviews');
    }
};
