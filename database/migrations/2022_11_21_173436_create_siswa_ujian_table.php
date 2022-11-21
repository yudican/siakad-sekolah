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
        Schema::create('siswa_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_ujian_id')->constrained('data_ujian')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('data_siswas')->cascadeOnDelete();
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
        Schema::dropIfExists('siswa_ujian');
    }
};
