<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataJurusan;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataJurusanTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_jurusans';

    public function builder()
    {
        return DataJurusan::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
Column::name('kode_jurusan')->label('Kode Jurusan')->searchable(),
Column::name('nama_jurusan')->label('Nama Jurusan')->searchable(),

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
                                        'route' => 'confirmDelete(' . $id . ')',
                                        'label' => 'Hapus',
                                    ]
                                ]
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataDataJurusanById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataJurusanId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
