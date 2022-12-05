<?php

namespace App\Http\Livewire\Table;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataSoalUjian;
use App\Models\DataUjian;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataUjianTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_ujian';

    public function builder()
    {
        $user = auth()->user();
        $role = $user->role->role_type;

        if (in_array($role, ['guru'])) {
            return DataUjian::query()->where('guru_id', $user->guru->id);
        }

        if (in_array($role, ['siswa'])) {
            return DataUjian::query()->whereHas('kelass', function ($query) use ($user) {
                $query->where('kelas_id', $user->kelas_id);
            });
        }

        return DataUjian::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('akademik.nama_akademik')->label('Akademik')->searchable(),
            Column::callback(['id', 'kelas_id'], function ($id, $kelas) {
                $user = auth()->user();
                $role = $user->role->role_type;
                $jadwal = DataUjian::find($id);
                if (in_array($role, ['siswa'])) {
                    return $user->siswa->kelas()->first()->nama_kelas;
                }
                $kelas_nama = $jadwal->kelass()->pluck('nama_kelas')->implode(',');
                return $kelas_nama;
            })->label('Kelas')->searchable(),
            Column::name('mapel.nama_mapel')->label('Mapel')->searchable(),
            Column::name('guru.nama_guru')->label('Guru')->searchable(),
            Column::name('tanggal_ujian')->label('Tanggal Ujian')->searchable(),
            Column::name('waktu_ujian')->label('Waktu Ujian')->searchable(),
            Column::name('jenis_ujian')->label('Jenis Ujian')->searchable(),
            Column::name('jenis_soal')->label('Jenis Soal')->searchable(),
            Column::name('keterangan')->label('Keterangan')->searchable(),
            Column::callback(['id', 'tanggal_ujian'], function ($id, $tanggal_ujian) {
                return DataSoalUjian::where('data_ujian_id', $id)->count() . ' Soal';
            })->label('Jumlah Soal')->searchable(),

            Column::callback(['id', 'jenis_soal', 'tanggal_ujian', 'waktu_ujian', 'kelas_id'], function ($id, $jenis_soal, $tanggal_ujian, $waktu_ujian, $kelas_id) {
                $user = auth()->user();
                $role = $user->role->role_type;

                if ($role == 'siswa') {
                    $ujian = DB::table('siswa_ujian')->where([
                        'data_ujian_id' => $id,
                        'siswa_id' => auth()->user()->siswa->id,
                    ])->first();
                    if ($ujian) {
                        if ($jenis_soal == 'pg') {
                            return 'Nilai ' .  DataJawabanUjian::where('data_ujian_id', $id)->where('siswa_id', auth()->user()->siswa->id)->where('status', 1)->count();
                        }

                        $jawabans = DataJawabaEssay::where('data_ujian_id', $id)->where('data_siswa_id', auth()->user()->siswa->id)->sum('nilai');

                        return "Nilai $jawabans";
                    }

                    $start = strtotime($tanggal_ujian . ' ' . $waktu_ujian);
                    $now = strtotime(date('Y-m-d H:i:s', strtotime('+2 hours')));

                    if ($start >= $now) {
                        return 'Belum Mulai';
                    }
                    $soal = DataSoalUjian::where('data_ujian_id', $id)->count();
                    if ($soal > 0) {
                        return '<a href="' . route('ujian-siswa', ['ujian_id' => $id]) . '" class="btn btn-primary btn-sm">Mulai Ujian</a>';
                    }

                    return 'Belum Ada Soal';
                }
                return view('crud-generator-components::action-button', [
                    'id' => $id,
                    'actions' => [
                        [
                            'type' => 'link',
                            'params' => ['ujian_id' => $id],
                            'label' => 'Lihat Kelas Ujian',
                            'route' => 'list-kelas-ujian'
                        ],
                        [
                            'type' => 'link',
                            'params' => ['data_ujian_id' => $id],
                            'label' => 'Lihat Soal',
                            'route' => 'data-soal-ujian'
                        ],
                        [
                            'type' => 'link',
                            'params' => ['ujian_id' => $id],
                            'label' => 'Input Nilai',
                            'route' => 'ujian-siswa'
                        ],
                        [
                            'type' => 'button',
                            'route' => 'getDataById(' . $id . ')',
                            'label' => 'Edit',
                        ],
                        [
                            'type' => 'button',
                            'route' => 'getId(' . $id . ')',
                            'label' => 'Hapus',
                        ]
                    ]
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataDataUjianById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataTugasId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
