<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Lepaskan sementara relasi angsuran.
        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropForeign(['pinjaman_id']);
        });

        // Ubah nama tabel pinjaman.
        Schema::rename('pinjaman', 'pinjamans');

        // Sesuaikan nama kolom dengan PDF dosen.
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->renameColumn(
                'jumlah_pinjaman',
                'jumlah_pengajuan'
            );

            $table->renameColumn(
                'bunga',
                'bunga_persen'
            );
        });

        // Tambahkan kolom yang dibutuhkan.
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->decimal('jumlah_disetujui', 15, 2)
                ->nullable();

            $table->unsignedSmallInteger('tenor_bulan')
                ->default(1);

            $table->text('tujuan')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->text('catatan_persetujuan')->nullable();

            $table->timestamp('disbursed_at')->nullable();

            $table->timestamp('lunas_at')->nullable();
        });

        // Sesuaikan status bawaan.
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->string('status', 20)
                ->default('diajukan')
                ->change();
        });

        // Hubungkan kembali tabel angsuran.
        Schema::table('angsuran', function (Blueprint $table) {
            $table->foreign('pinjaman_id')
                ->references('id')
                ->on('pinjamans')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Lepaskan relasi angsuran.
        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropForeign(['pinjaman_id']);
        });

        // Hapus kolom tambahan.
        Schema::table('pinjamans', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'jumlah_disetujui',
                'tenor_bulan',
                'tujuan',
                'approved_by',
                'approved_at',
                'catatan_persetujuan',
                'disbursed_at',
                'lunas_at',
            ]);

            $table->renameColumn(
                'jumlah_pengajuan',
                'jumlah_pinjaman'
            );

            $table->renameColumn(
                'bunga_persen',
                'bunga'
            );
        });

        // Kembalikan nama tabel.
        Schema::rename('pinjamans', 'pinjaman');

        // Kembalikan relasi angsuran.
        Schema::table('angsuran', function (Blueprint $table) {
            $table->foreign('pinjaman_id')
                ->references('id')
                ->on('pinjaman')
                ->onDelete('cascade');
        });
    }
};
