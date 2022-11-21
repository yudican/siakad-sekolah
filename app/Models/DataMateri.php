<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMateri extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_materi';
    //public $incrementing = false;

    protected $fillable = ['akademik_id', 'deskripsi_materi', 'file', 'guru_id', 'link', 'mapel_id', 'nama_materi'];

    protected $dates = [];

    /**
     * Get the akademik that owns the DataMateri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akademik()
    {
        return $this->belongsTo(DataAkademik::class, 'akademik_id');
    }

    /**
     * Get the akademik that owns the DataMateri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        return $this->belongsTo(DataGuru::class, 'guru_id');
    }

    /**
     * Get the akademik that owns the DataMateri
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        return $this->belongsTo(DataMapel::class, 'mapel_id');
    }
}
