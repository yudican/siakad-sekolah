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
        Schema::create('data_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nip', 16);
            $table->string('nama_guru', 191)->nullable();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->string('tempat_lahir', 191)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 191)->nullable();
            $table->string('alamat', 191)->nullable();
            $table->string('no_hp', 191)->nullable();
            $table->string('npwp', 191)->nullable();
            $table->string('pendidikan_terakhir', 191)->nullable();
            $table->string('jurusan', 191)->nullable();
            $table->string('status_kepegawaian', 191)->nullable();
            $table->boolean('status_aktif')->nullable()->default(true);
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
        Schema::dropIfExists('data_guru');
    }
};
