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
        Schema::create('data_akademiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_semester_id')->constrained('data_semesters')->onDelete('cascade');
            $table->string('kode_akademik', 191);
            $table->string('nama_akademik', 191);
            $table->boolean('status_akademik')->default(0);

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
        Schema::dropIfExists('data_akademiks');
    }
};
