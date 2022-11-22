<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKelas extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['kode_kelas', 'nama_kelas', 'guru_id', 'akademik_id'];

    protected $dates = [];

    public function waliKelas()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }

    public function akademik()
    {
        return $this->belongsTo(DataAkademik::class, 'akademik_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(DataSiswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id');
    }

    public function ujian()
    {
        return $this->hasMany(DataUjian::class, 'kelas_id');
    }
}
