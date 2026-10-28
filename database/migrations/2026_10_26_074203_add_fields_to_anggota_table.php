<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->string('no_anggota')->nullable()->unique();
            $table->string('nik', 16)->nullable()->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('status')->default('Aktif');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropUnique(['no_anggota']);
            $table->dropUnique(['nik']);
            $table->dropColumn([
                'no_anggota',
                'nik',
                'jenis_kelamin',
                'status',
            ]);
        });
    }
};
