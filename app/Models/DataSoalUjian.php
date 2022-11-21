<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSoalUjian extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['data_ujian_id', 'nama_soal', 'gambar_soal'];

    protected $dates = [];

    public function dataUjian()
    {
        return $this->belongsTo(DataUjian::class, 'data_ujian_id');
    }

    public function dataPilihanJawaban()
    {
        return $this->hasMany(DataPilihanJawaban::class, 'data_soal_ujian_id');
    }
}
