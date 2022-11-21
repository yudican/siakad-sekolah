<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataJadwalPelajaran;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class DataJadwalPelajaranTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_jadwal_pelajaran';

    public function builder()
    {
        return DataJadwalPelajaran::query()->whereHas('akademik', function ($query) {
            return $query->where('status_akademik', 1);
        })->orderBy('hari', 'asc')->orderBy('data_jadwal_pelajaran.created_at', 'asc');
    }

    public function columns()
    {
        return [
            Column::name('id')->label('No.'),
            Column::name('akademik.nama_akademik')->label('Akademik')->searchable(),
            Column::name('kelas.nama_kelas')->label('Kelas')->searchable(),
            Column::name('mapel.nama_mapel')->label('Mata Pelajaran')->searchable(),
            Column::name('guru.nama_guru')->label('Guru Pengampu')->searchable(),
            Column::callback('hari', function ($hari) {
                return namaHari($hari);
            })->label('Hari')->searchable(),
            Column::name('jam_mulai')->label('Jam Mulai')->searchable(),
            Column::name('jam_selesai')->label('Jam Selesai')->searchable(),

            Column::callback(['id'], function ($id) {
                $user = auth()->user();
                $role = $user->role->role_type;

                if (in_array($role, ['superadmin'])) {
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
                }
                return '';
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataDataJadwalPelajaranById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataJadwalPelajaranId', $id);
        $this->emit('showModalConfirm', 'show');
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
