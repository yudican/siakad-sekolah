<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataAkademik;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataAkademikTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_akademiks';

    public function builder()
    {
        return DataAkademik::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('data_semester_id')->label('Pilih Semester')->searchable(),
            Column::name('kode_akademik')->label('Kode Akademik')->searchable(),
            Column::name('nama_akademik')->label('Nama Akademik')->searchable(),
            Column::name('status_akademik')->label('Status Akademik')->searchable(),

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
        $this->emit('getDataDataAkademikById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataAkademikId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
