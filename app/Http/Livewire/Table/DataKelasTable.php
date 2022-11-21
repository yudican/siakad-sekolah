<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataKelas;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataKelasTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_kelas';

    public function builder()
    {
        return DataKelas::query();
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('kode_kelas')->label('Kode Kelas')->searchable(),
            Column::name('nama_kelas')->label('Nama Kelas')->searchable(),
            Column::callback(['id', 'kode_kelas'], function ($id, $kode_kelas) {
                $kelas = DataKelas::find($id);
                return $kelas->siswa()->count();
            })->label('Jumlah Siswa')->searchable(),

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
        $this->emit('getDataDataKelasById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataKelasId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
