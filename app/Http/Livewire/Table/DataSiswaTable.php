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
            Column::name('user.email')->label('Nama Siswa')->searchable(),
            Column::name('jenis_kelamin')->label('Jenis Kelamin')->searchable(),

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
