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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('area_id')->constrained('areas')->restrictOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->dateTime('waktu_kejadian');
            $table->string('bukti_path')->nullable(); // Lokasi penyimpanan bukti (gambar/pdf)
            $table->enum('status', [
                'menunggu_peninjauan',
                'diverifikasi',
                'ditolak',
                'diteruskan',
                'selesai'
            ])->default('menunggu_peninjauan')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
