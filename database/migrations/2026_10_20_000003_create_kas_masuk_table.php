<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('no', 20)->nullable()->unique(); // KM-00001, diisi setelah data tersimpan
            $table->date('tanggal');
            $table->foreignId('jenis_dana_id')->constrained('jenis_dana')->restrictOnDelete();
            $table->foreignId('donatur_id')->nullable()->constrained('donatur')->restrictOnDelete(); // kosong = donasi anonim
            $table->unsignedBigInteger('nominal'); // rupiah bulat
            $table->text('keterangan')->nullable();
            $table->foreignId('dicatat_oleh')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_masuk');
    }
};
