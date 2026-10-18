<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
            $table->date('tanggal_pinjaman');
            $table->decimal('jumlah_pinjaman', 12, 2);
            $table->decimal('bunga', 5, 2)->default(0);
            $table->string('status')->default('belum lunas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
