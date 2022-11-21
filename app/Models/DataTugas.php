<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTugas extends Model
{
    //use Uuid;
    use HasFactory;

    //public $incrementing = false;

    protected $fillable = ['deskripsi_tugas', 'due_date', 'kelas_id', 'materi_id', 'nama_tugas', 'file'];

    protected $dates = ['due_date'];

    /**
     * Get the kelas that owns the DataTugas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'kelas_id');
    }

    /**
     * Get the materi that owns the DataTugas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materi()
    {
        return $this->belongsTo(DataMateri::class, 'materi_id');
    }

    /**
     * Get all of the pengumpulanTugas for the DataTugas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
