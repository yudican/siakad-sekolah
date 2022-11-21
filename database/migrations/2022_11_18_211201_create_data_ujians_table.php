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
        Schema::create('data_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akademik_id')->constrained('data_akademiks');
            $table->foreignId('kelas_id')->constrained('data_kelas');
            $table->foreignId('mapel_id')->constrained('data_mapels');
            $table->foreignId('guru_id')->constrained('data_guru');
            $table->date('tanggal_ujian');
            $table->time('waktu_pengerjaan');
            $table->integer('waktu_ujian');
            $table->enum('jenis_ujian', ['UTS', 'UAS', 'UH']);
            $table->enum('jenis_soal', ['pg', 'essay']);
            $table->text('keterangan');
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
        Schema::dropIfExists('data_ujian');
    }
};
