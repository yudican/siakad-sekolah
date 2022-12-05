<?php

use App\Http\Controllers\AuthController;
// use App\Http\Livewire\CrudGenerator;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Settings\Menu;
use App\Http\Livewire\UserManagement\Permission;
use App\Http\Livewire\UserManagement\PermissionRole;
use App\Http\Livewire\UserManagement\Role;
use App\Http\Livewire\UserManagement\User;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Master\DataSemesterController;
use App\Http\Livewire\Master\DataAkademikController;
use App\Http\Livewire\Master\DataMapelController;
use App\Http\Livewire\Master\DataKelasController;
use App\Http\Livewire\Akademik\DataGuruController;
use App\Http\Livewire\Akademik\DataSiswaController;
use App\Http\Livewire\Akademik\KelasSiswa;



use App\Http\Livewire\Akademik\DataMateriController;
use App\Http\Livewire\Akademik\DataTugasController;
use App\Http\Livewire\Akademik\PengumpulanTugasController;
use App\Http\Livewire\Akademik\DataJadwalPelajaranController;
use App\Http\Livewire\Akademik\DataUjianController;
use App\Http\Livewire\Akademik\DataSoalUjianController;
use App\Http\Livewire\Akademik\UjianSiswaController;
use App\Http\Livewire\JawabanUjianSiswaController;
use App\Http\Livewire\KelasUjian;
use App\Http\Livewire\ListUjianSiswaController;

use App\Http\Livewire\Master\DataJurusanController;
// [route_import_path]

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});


Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::group(['middleware' => ['auth:sanctum', 'verified', 'user.authorization']], function () {
    // Crud Generator Route
    // Route::get('/crud-generator', CrudGenerator::class)->name('crud.generator');

    // user management
    Route::get('/permission', Permission::class)->name('permission');
    Route::get('/permission-role/{role_id}', PermissionRole::class)->name('permission.role');
    Route::get('/role', Role::class)->name('role');
    Route::get('/user', User::class)->name('user');
    Route::get('/menu', Menu::class)->name('menu');

    // App Route
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Master data

    Route::get('/data-semester', DataSemesterController::class)->name('data-semester');
    Route::get('/data-akademik', DataAkademikController::class)->name('data-akademik');
    Route::get('/data-mapel', DataMapelController::class)->name('data-mapel');
    Route::get('/data-kelas', DataKelasController::class)->name('data-kelas');
    Route::get('/data-guru', DataGuruController::class)->name('data-guru');
    Route::get('/data-siswa', DataSiswaController::class)->name('data-siswa');
    Route::get('/kelas-siswa', KelasSiswa::class)->name('kelas-siswa');

    Route::get('/data-tugas', DataTugasController::class)->name('data-tugas');
    Route::get('/data-materi', DataMateriController::class)->name('data-materi');
    Route::get('/data-tuga', DataTugasController::class)->name('data-tuga');
    Route::get('/pengumpulan-tuga', PengumpulanTugasController::class)->name('pengumpulan-tuga');
    Route::get('/data-jadwal-pelajaran', DataJadwalPelajaranController::class)->name('data-jadwal-pelajaran');
    Route::get('/data-ujian', DataUjianController::class)->name('data-ujian');
    Route::get('/data-soal-ujian/{data_ujian_id}', DataSoalUjianController::class)->name('data-soal-ujian');
    Route::get('/ujian-siswa/{ujian_id}', UjianSiswaController::class)->name('ujian-siswa');
    Route::get('/list-kelas-ujian/{ujian_id}', KelasUjian::class)->name('list-kelas-ujian');
    Route::get('/list-ujian-siswa/{kelas_id}/{ujian_id}', ListUjianSiswaController::class)->name('list-ujian-siswa');
    Route::get('/list-jawaban-ujian-siswa/{ujian_id}/{siswa_id}', JawabanUjianSiswaController::class)->name('list-jawaban-ujian-siswa');
    Route::get('/data-jurusan', DataJurusanController::class)->name('data-jurusan');
    // [route_path]

});
