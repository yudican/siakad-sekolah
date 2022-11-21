<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataSemester;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataSemesterTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_semesters';

    public function builder()
    {
        return DataSemester::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('kode_semester')->label('Kode Semester')->searchable(),
            Column::name('nama_semester')->label('Nama Semester')->searchable(),
            Column::name('status_semester')->label('Status Semester')->searchable(),

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
        $this->emit('getDataDataSemesterById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataSemesterId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
