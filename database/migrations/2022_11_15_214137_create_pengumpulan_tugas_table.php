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
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained('data_tugas')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('data_siswas')->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->text('catatan')->nullable();
            $table->char('nilai', 5)->nullable()->default(0);
            $table->char('status', 1)->nullable()->default(0); // 0 = belum dinilai, 1 = sudah dinilai, 2 = tidak mengumpulkan
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
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
