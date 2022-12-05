<?php

namespace App\Http\Livewire\Table;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class KelasUjianTable extends LivewireDatatable
{
  protected $listeners = ['refreshTable'];
  public $hideable = 'select';

  public function builder()
  {
    return DataKelas::query()->whereHas('ujians', function ($query) {
      $query->where('data_ujian.id', $this->params['ujian_id']);
    });
  }

  public function columns()
  {
    return [
      Column::name('id')->label('No.'),
      Column::name('kode_kelas')->label('Kode Kelas')->searchable(),
      Column::name('nama_kelas')->label('Nama Kelas')->searchable(),

      Column::callback(['id'], function ($id) {
        return view('crud-generator-components::action-button', [
          'id' => $id,
          'actions' => [
            [
              'type' => 'link',
              'params' => ['ujian_id' => $this->params['ujian_id'], 'kelas_id' => $id],
              'label' => 'Lihat Peserta Ujian',
              'route' => 'list-ujian-siswa'
            ],
          ]
        ]);
      })->label(__('Aksi')),
    ];
  }

  public function refreshTable()
  {
    $this->emit('refreshLivewireDatatable');
  }
}
