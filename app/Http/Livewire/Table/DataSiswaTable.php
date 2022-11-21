<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataSiswa;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataSiswaTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_siswas';

    public function builder()
    {
        return DataSiswa::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('nis')->label('Nis')->searchable(),
            Column::name('nama_siswa')->label('Nama Siswa')->searchable(),
            Column::name('jenis_kelamin')->label('Jenis Kelamin')->searchable(),
            Column::name('tempat_lahir')->label('Tempat Lahir')->searchable(),
            Column::name('tanggal_lahir')->label('Tanggal Lahir')->searchable(),
            Column::name('agama')->label('Agama')->searchable(),
            Column::name('alamat')->label('Alamat')->searchable(),
            Column::name('no_hp')->label('No Hp')->searchable(),
            Column::name('nama_ayah')->label('Nama Ayah')->searchable(),
            Column::name('nama_ibu')->label('Nama Ibu')->searchable(),
            Column::name('pekerjaan_ayah')->label('Pekerjaan Ayah')->searchable(),
            Column::name('pekerjaan_ibu')->label('Pekerjaan Ibu')->searchable(),
            Column::name('no_hp_ortu')->label('No Hp Ortu')->searchable(),
            Column::name('alamat_ortu')->label('Alamat Ortu')->searchable(),
            Column::name('nama_wali')->label('Nama Wali')->searchable(),
            Column::name('pekerjaan_wali')->label('Pekerjaan Wali')->searchable(),
            Column::name('no_hp_wali')->label('No Hp Wali')->searchable(),
            Column::name('alamat_wali')->label('Alamat Wali')->searchable(),
            Column::name('asal_sekolah')->label('Asal Sekolah')->searchable(),
            Column::name('tahun_lulus')->label('Tahun Lulus')->searchable(),
            Column::name('alamat_asal_sekolah')->label('Alamat Asal Sekolah')->searchable(),
            Column::name('no_ijazah')->label('No Ijazah')->searchable(),
            Column::name('no_skhun')->label('No Skhun')->searchable(),
            Column::name('no_un')->label('No Un')->searchable(),
            Column::name('no_seri_ijazah')->label('No Seri Ijazah')->searchable(),
            Column::name('no_seri_skhun')->label('No Seri Skhun')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('crud-generator-components::action-button', [
                    'id' => $id,
                    'actions' => [
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
        $this->emit('getDataDataSiswaById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataSiswaId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
