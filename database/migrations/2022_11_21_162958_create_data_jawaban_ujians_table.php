<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_jawaban_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_ujian_id')->constrained('data_ujian');
            $table->foreignId('data_soal_ujian_id')->constrained('data_soal_ujians');
            $table->foreignId('data_pilihan_jawaban_id')->constrained('data_pilihan_jawabans');
            $table->foreignId('siswa_id')->constrained('data_siswas');
            $table->boolean('status')->default(false);
            $table->boolean('is_answered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_jawaban_ujians');
    }
};
