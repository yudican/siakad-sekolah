<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJawabaEssay extends Model
{
    use HasFactory;

    protected $table = 'data_jawaba_essay';

    protected $guarded = [];

    public function dataUjian()
    {
        return $this->belongsTo(DataUjian::class, 'data_ujian_id');
    }

    public function dataSoalUjian()
    {
        return $this->belongsTo(DataSoalUjian::class, 'data_soal_ujian_id');
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }
}
