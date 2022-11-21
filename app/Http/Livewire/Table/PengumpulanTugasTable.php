<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\PengumpulanTugas;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class PengumpulanTugasTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_pengumpulan_tugas';

    public function builder()
    {
        return PengumpulanTugas::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('catatan')->label('Catatan')->searchable(),
            Column::callback(['file'], function ($file) {
                if ($file) {
                    $link = asset('storage/' . $file);
                    return '<a href="' . $link . '" target="_blank">show file</a>';
                }
                return '-';
            })->label(__('File')),
            Column::name('nilai')->label('Nilai')->searchable(),
            Column::name('siswa.nama_siswa')->label('Siswa')->searchable(),
            Column::name('status')->label('Status')->searchable(),
            Column::name('tugas.nama_tugas')->label('Tugas')->searchable(),

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
        $this->emit('getDataPengumpulanTugasById', $id);
    }

    public function getId($id)
    {
        $this->emit('getPengumpulanTugasId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
