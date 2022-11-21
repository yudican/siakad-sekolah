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
        Schema::create('data_jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akademik_id')->constrained('data_akademiks');
            $table->foreignId('kelas_id')->constrained('data_kelas');
            $table->foreignId('mapel_id')->constrained('data_mapels');
            $table->foreignId('guru_id')->constrained('data_guru');
            $table->string('hari', 191);
            $table->string('jam_mulai', 191);
            $table->string('jam_selesai', 191);
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
        Schema::dropIfExists('data_jadwal_pelajaran');
    }
};
