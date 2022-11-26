<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataGuru;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataGuruTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_guru';

    public function builder()
    {
        return DataGuru::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('nip')->label('Nip')->searchable(),
            Column::name('nama_guru')->label('Nama Guru')->searchable(),
            Column::name('jenis_kelamin')->label('Jenis Kelamin')->searchable(),
            // Column::name('tempat_lahir')->label('Tempat Lahir')->searchable(),
            // Column::name('tanggal_lahir')->label('Tanggal Lahir')->searchable(),
            // Column::name('agama')->label('Agama')->searchable(),
            // Column::name('alamat')->label('Alamat')->searchable(),
            // Column::name('no_hp')->label('No Hp')->searchable(),
            // Column::name('npwp')->label('Npwp')->searchable(),
            Column::name('pendidikan_terakhir')->label('Pendidikan Terakhir')->searchable(),
            // Column::name('jurusan')->label('Jurusan')->searchable(),
            Column::name('status_kepegawaian')->label('Status Kepegawaian')->searchable(),
            // Column::name('status_aktif')->label('Status Aktif')->searchable(),

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
        $this->emit('getDataDataGuruById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataGuruId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
