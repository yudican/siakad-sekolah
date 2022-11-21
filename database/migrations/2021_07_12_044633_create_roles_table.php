<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('role_type', 191);
            $table->string('role_name', 191);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'id' => 'aaf5ab14-a1cd-46c9-9838-84188cd064b6',
                'role_type' => 'superadmin',
                'role_name' => 'Superadmin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'id' => '0c1afb3f-1de0-4cb4-a512-f8ef9fc8e816',
                'role_type' => 'guru',
                'role_name' => 'Guru',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'id' => '0feb7d3a-90c0-42b9-be3f-63757088cb9a',
                'role_type' => 'wali_kelas',
                'role_name' => 'Wali kelas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'id' => '90598899-416f-4de0-947f-c77ac2ca4eb2',
                'role_type' => 'siswa',
                'role_name' => 'Siswa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
