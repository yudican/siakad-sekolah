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
        Schema::create('data_pilihan_jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_soal_ujian_id')->constrained('data_soal_ujians');
            $table->string('pilihan_jawaban');
            $table->boolean('kunci_jawaban')->default(false);
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
        Schema::dropIfExists('data_pilihan_jawabans');
    }
};
