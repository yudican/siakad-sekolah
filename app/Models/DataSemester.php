<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSemester extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['kode_semester', 'nama_semester', 'status_semester'];

    protected $dates = [];

    public function dataAkademik()
    {
        return $this->hasMany(DataAkademik::class, 'data_semester_id');
    }
}
