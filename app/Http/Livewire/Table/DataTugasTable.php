<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataTugas;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataTugasTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_tugas';

    public function builder()
    {
        return DataTugas::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('deskripsi_tugas')->label('Deskripsi Tugas')->searchable(),
            Column::name('due_date')->label('Due Date')->searchable(),
            Column::callback(['file'], function ($file) {
                if ($file) {
                    $link = asset('storage/' . $file);
                    return '<a href="' . $link . '" target="_blank">show file</a>';
                }
                return '-';
            })->label(__('File')),
            Column::name('kelas.nama_kelas')->label('Kelas')->searchable(),
            Column::name('materi.nama_materi')->label('Materi')->searchable(),
            Column::name('nama_tugas')->label('Nama Tugas')->searchable(),

            Column::callback(['id'], function ($id) {
                $role = auth()->user()->role->role_type;
                $menu = [
                    [
                        'type' => 'button',
                        'route' => "getDataById('$id','update')",
                        'label' => 'Edit',
                    ],
                    [
                        'type' => 'button',
                        'route' => "getDataById('$id','detail')",
                        'label' => 'Detail',
                    ],
                    [
                        'type' => 'button',
                        'route' => "getDataById('$id','pengumpulan')",
                        'label' => 'Pengumpulan',
                    ],
                    [
                        'type' => 'button',
                        'route' => 'getId(' . $id . ')',
                        'label' => 'Hapus',
                    ]
                ];

                if ($role == 'siswa') {
                    $menu = [
                        [
                            'type' => 'button',
                            'route' => "getDataById('$id','detail')",
                            'label' => 'Detail',
                        ],
                    ];
                }

                return view('crud-generator-components::action-button', [
                    'id' => $id,
                    'actions' => $menu
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id, $type)
    {
        $this->emit('getDataDataTugasById', $id, $type);
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
