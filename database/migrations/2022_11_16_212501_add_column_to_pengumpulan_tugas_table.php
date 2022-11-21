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
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->dateTime('tanggal_kirim')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengumpulan_tugas', function (Blueprint $table) {
            $table->dropColumn('tanggal_kirim');
        });
    }
};
