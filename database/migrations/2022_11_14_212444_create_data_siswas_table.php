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
        Schema::create('data_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nis', 16);
            $table->string('nama_siswa', 191)->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir', 191)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 191)->nullable();
            $table->string('alamat', 191)->nullable();
            $table->string('no_hp', 191)->nullable();
            $table->string('nama_ayah', 191)->nullable();
            $table->string('nama_ibu', 191)->nullable();
            $table->string('pekerjaan_ayah', 191)->nullable();
            $table->string('pekerjaan_ibu', 191)->nullable();
            $table->string('no_hp_ortu', 191)->nullable();
            $table->string('alamat_ortu', 191)->nullable();
            $table->string('nama_wali', 191)->nullable();
            $table->string('pekerjaan_wali', 191)->nullable();
            $table->string('no_hp_wali', 191)->nullable();
            $table->string('alamat_wali', 191)->nullable();
            $table->string('asal_sekolah', 191)->nullable();
            $table->string('tahun_lulus', 191)->nullable();
            $table->string('alamat_asal_sekolah', 191)->nullable();
            $table->string('no_ijazah', 191)->nullable();
            $table->string('no_skhun', 191)->nullable();
            $table->string('no_un', 191)->nullable();
            $table->string('no_seri_ijazah', 191)->nullable();
            $table->string('no_seri_skhun', 191)->nullable();
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
        Schema::dropIfExists('data_siswas');
    }
};
