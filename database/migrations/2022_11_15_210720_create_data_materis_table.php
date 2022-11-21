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
        Schema::create('data_materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akademik_id')->constrained('data_akademiks')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained('data_mapels')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('data_guru')->cascadeOnDelete()->nullable();
            $table->string('nama_materi', 191)->nullable();
            $table->text('deskripsi_materi')->nullable();
            $table->string('link')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('data_materi');
    }
};
