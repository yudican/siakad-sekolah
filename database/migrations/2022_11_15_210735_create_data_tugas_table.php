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
        Schema::create('data_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('data_kelas')->cascadeOnDelete();
            $table->foreignId('materi_id')->constrained('data_materi')->cascadeOnDelete();
            $table->string('nama_tugas')->nullable();
            $table->text('deskripsi_tugas')->nullable();
            $table->string('file')->nullable();
            $table->dateTime('due_date')->nullable();
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
        Schema::dropIfExists('data_tugas');
    }
};
