<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMapel extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['kode_mapel', 'nama_mapel', 'status_mapel'];

    protected $dates = [];

    public function materi()
    {
        return $this->hasMany(DataMateri::class, 'mapel_id');
    }
}
