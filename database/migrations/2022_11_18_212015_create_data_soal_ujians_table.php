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
        Schema::create('data_soal_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_ujian_id')->constrained('data_ujian');
            $table->string('nama_soal', 191);
            $table->string('gambar_soal', 191)->nullable();
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
        Schema::dropIfExists('data_soal_ujians');
    }
};
