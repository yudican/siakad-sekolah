<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataMateri;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataMateriTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_materi';

    public function builder()
    {
        return DataMateri::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('akademik.nama_akademik')->label('Akademik')->searchable(),
            Column::name('deskripsi_materi')->label('Deskripsi Materi')->searchable(),
            Column::callback(['file'], function ($file) {
                if ($file) {
                    $link = asset('storage/' . $file);
                    return '<a href="' . $link . '" target="_blank">show file</a>';
                }
                return '-';
            })->label(__('File')),
            Column::name('guru.nama_guru')->label('Guru')->searchable(),
            Column::name('link')->label('Link')->searchable(),
            Column::name('mapel.nama_mapel')->label('Mata Pelajaran')->searchable(),
            Column::name('nama_materi')->label('Nama Materi')->searchable(),

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
        $this->emit('getDataDataMateriById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataMateriId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
