<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataSoalUjian;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataSoalUjianTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_soal_ujians';

    public function builder()
    {
        return DataSoalUjian::query()->where('data_ujian_id', $this->params['data_ujian_id']);
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('nama_soal')->label('Nama Soal')->searchable(),

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
        $this->emit('getDataDataSoalUjianById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataSoalUjianId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
