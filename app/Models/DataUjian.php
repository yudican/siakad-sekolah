<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUjian extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_ujian';
    //public $incrementing = false;

    protected $fillable = ['akademik_id', 'kelas_id', 'mapel_id', 'guru_id', 'tanggal_ujian', 'waktu_ujian', 'waktu_pengerjaan', 'jenis_ujian', 'jenis_soal', 'keterangan'];

    protected $dates = [];

    public function akademik()
    {
        return $this->belongsTo(DataAkademik::class, 'akademik_id');
    }

    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'kelas_id');
    }

    public function kelass()
    {
        return $this->belongsToMany(DataKelas::class, 'kelas_ujian', 'ujian_id', 'kelas_id');
    }

    public function mapel()
    {
        return $this->belongsTo(DataMapel::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }

    /**
     * The siswas that belong to the DataUjian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function siswas()
    {
        return $this->belongsToMany(DataSiswa::class, 'siswa_ujian', 'data_ujian_id', 'siswa_id');
    }
}
