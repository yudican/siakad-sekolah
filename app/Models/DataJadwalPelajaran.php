<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJadwalPelajaran extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_jadwal_pelajaran';
    //public $incrementing = false;

    protected $fillable = ['akademik_id', 'kelas_id', 'mapel_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai'];

    protected $dates = [];

    public function akademik()
    {
        return $this->belongsTo(DataAkademik::class, 'akademik_id');
    }

    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'kelas_id');
    }

    public function mapel()
    {
        return $this->belongsTo(DataMapel::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }
}
