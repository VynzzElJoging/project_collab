<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('anggota_id')
                ->constrained('anggotas')
                ->restrictOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();

            $table->string('status')
                ->default('dipinjam');

            $table->unsignedInteger('denda')
                ->default(0);

            $table->timestamps();

            $table->index(['anggota_id', 'status']);
            $table->index('tanggal_jatuh_tempo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
