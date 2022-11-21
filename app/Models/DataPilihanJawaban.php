<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPilihanJawaban extends Model
{
    use HasFactory;

    protected $fillable = ['data_soal_ujian_id', 'pilihan_jawaban', 'kunci_jawaban'];
}
