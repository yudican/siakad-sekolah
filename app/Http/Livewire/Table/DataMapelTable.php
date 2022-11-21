<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataMapel;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataMapelTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_mapels';

    public function builder()
    {
        return DataMapel::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('kode_mapel')->label('Kode Mapel')->searchable(),
            Column::name('nama_mapel')->label('Nama Mapel')->searchable(),
            Column::name('status_mapel')->label('Status Mapel')->searchable(),

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
        $this->emit('getDataDataMapelById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataMapelId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
