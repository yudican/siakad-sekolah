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
        Schema::create('data_jawaba_essay', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_soal_ujian_id')->constrained('data_soal_ujians')->onDelete('cascade');
            $table->foreignId('data_ujian_id')->constrained('data_ujian')->onDelete('cascade');
            $table->foreignId('data_siswa_id')->constrained('data_siswas')->onDelete('cascade');
            $table->text('jawaban')->nullable();
            $table->char('nilai', 5)->default(0);
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
        Schema::dropIfExists('data_jawaba_essay');
    }
};
