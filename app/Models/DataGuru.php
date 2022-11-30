<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    use HasFactory;

    protected $table = 'data_guru';
    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'npwp',
        'pendidikan_terakhir',
        'jurusan',
        'status_kepegawaian',
        'status_aktif',
    ];

    protected $dates = ['tanggal_lahir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(DataKelas::class, 'guru_id');
    }

    public function materi()
    {
        return $this->hasMany(DataMateri::class, 'guru_id');
    }

    /**
     * Get all of the jadwal for the DataGuru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal(): HasMany
    {
        return $this->hasMany(DataJadwalPelajaran::class, 'guru_id');
    }

    /**
     * Get all of the ujian for the DataGuru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujian(): HasMany
    {
        return $this->hasMany(DataUjian::class, 'guru_id');
    }
}
