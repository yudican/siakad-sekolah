<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAkademik extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['data_semester_id', 'kode_akademik', 'nama_akademik', 'status_akademik'];

    protected $dates = [];

    public function dataKelas()
    {
        return $this->hasMany(DataKelas::class, 'akademik_id');
    }

    public function dataSemester()
    {
        return $this->belongsTo(DataSemester::class, 'data_semester_id');
    }

    public function materi()
    {
        return $this->hasMany(DataMateri::class, 'akademik_id');
    }
}
