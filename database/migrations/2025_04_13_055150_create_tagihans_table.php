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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->index();
            $table->foreignId('user_id')->index();
            $table->integer('angkatan');
            $table->integer('program');
            $table->date('tanggal_tagihan');
            $table->date('tanggal_jatuh_tempo');
            $table->string('nama_biaya');
            $table->double('jumlah_biaya');
            $table->string('keterangan')->nullable();
            $table->double('denda');
            $table->enum('status', ['baru', 'angsuran', 'lunas']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
