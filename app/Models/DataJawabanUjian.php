<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJawabanUjian extends Model
{
    use HasFactory;

    protected $fillable = ['data_ujian_id', 'data_soal_ujian_id', 'data_pilihan_jawaban_id', 'siswa_id', 'status', 'is_answered'];

    public function dataUjian()
    {
        return $this->belongsTo(DataUjian::class, 'data_ujian_id');
    }

    public function dataSoalUjian()
    {
        return $this->belongsTo(DataSoalUjian::class, 'data_soal_ujian_id');
    }

    public function dataPilihanJawaban()
    {
        return $this->belongsTo(DataPilihanJawaban::class, 'data_pilihan_jawaban_id');
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }
}
