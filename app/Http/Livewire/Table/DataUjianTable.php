<?php

namespace App\Http\Livewire\Table;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataSoalUjian;
use App\Models\HideableColumn;
use App\Models\DataUjian;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataUjianTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_ujian';

    public function builder()
    {
        return DataUjian::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('akademik.nama_akademik')->label('Akademik')->searchable(),
            Column::name('kelas.nama_kelas')->label('Kelas')->searchable(),
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

            Column::callback(['id', 'jenis_ujian'], function ($id, $jenis_ujian) {
                $user = auth()->user();
                $role = $user->role->role_type;

                if ($role == 'siswa') {
                    $ujian = DB::table('siswa_ujian')->where([
                        'data_ujian_id' => $id,
                        'siswa_id' => auth()->user()->siswa->id,
                    ])->first();
                    if ($ujian) {
                        if ($jenis_ujian == 'pg') {
                            // hitung nilai
                            $benar = 0;
                            $salah = 0;
                            $jawabans = DataJawabanUjian::where('data_ujian_id', $id)->where('siswa_id', auth()->user()->siswa->id)->get();

                            foreach ($jawabans as $jawaban) {
                                if ($jawaban->status) {
                                    $benar++;
                                } else {
                                    $salah++;
                                }
                            }

                            return $benar . ' Benar, ' . $salah . ' Salah';
                        }

                        $jawabans = DataJawabaEssay::where('data_ujian_id', $id)->where('data_siswa_id', auth()->user()->siswa->id)->sum('nilai');

                        return "Nilai $jawabans";
                    }
                    return '<a href="' . route('ujian-siswa', ['ujian_id' => $id]) . '" class="btn btn-primary btn-sm">Mulai Ujian</a>';
                }
                return view('crud-generator-components::action-button', [
                    'id' => $id,
                    'actions' => [
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
