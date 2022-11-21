<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswa extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['user_id', 'nis', 'nama_siswa', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'no_hp', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'no_hp_ortu', 'alamat_ortu', 'nama_wali', 'pekerjaan_wali', 'no_hp_wali', 'alamat_wali', 'asal_sekolah', 'tahun_lulus', 'alamat_asal_sekolah', 'no_ijazah', 'no_skhun', 'no_un', 'no_seri_ijazah', 'no_seri_skhun'];

    protected $dates = ['tanggal_lahir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(DataKelas::class, 'kelas_siswa', 'siswa_id', 'kelas_id');
    }

    /**
     * The siswas that belong to the DataUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dataUjians()
    {
        return $this->belongsToMany(DataUjian::class, 'siswa_ujian', 'siswa_id', 'data_ujian_id');
    }
}
