<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
            $table->date('tanggal_simpanan');
            $table->decimal('jumlah', 12, 2);
            $table->string('jenis_simpanan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simpanan');
    }
};
