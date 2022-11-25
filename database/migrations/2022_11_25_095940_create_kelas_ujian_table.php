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
        Schema::create('kelas_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('data_kelas')->cascadeOnDelete();
            $table->foreignId('ujian_id')->constrained('data_ujian')->cascadeOnDelete();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_ujian');
    }
};
