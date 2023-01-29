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
        Schema::table('data_tugas', function (Blueprint $table) {
            $table->date('tanggal_mulai')->nullable()->after('due_date');
            $table->time('waktu_mulai')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_tugas', function (Blueprint $table) {
            $table->dropColumn('tanggal_mulai');
            $table->dropColumn('waktu_mulai');
        });
    }
};
