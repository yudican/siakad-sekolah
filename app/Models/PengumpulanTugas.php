<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['catatan', 'file', 'nilai', 'siswa_id', 'status', 'tugas_id', 'tanggal_kirim'];

    protected $dates = [];

    /**
     * Get the siswa that owns the PengumpulanTugas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'siswa_id');
    }

    /**
     * Get the tugas that owns the PengumpulanTugas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tugas()
    {
        return $this->belongsTo(DataTugas::class, 'tugas_id');
    }
}
