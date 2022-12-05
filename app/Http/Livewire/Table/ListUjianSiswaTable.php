<?php

namespace App\Http\Livewire\Table;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataSiswa;
use App\Models\DataSoalUjian;
use App\Models\HideableColumn;
use App\Models\DataUjian;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class ListUjianSiswaTable extends LivewireDatatable
{
  protected $listeners = ['refreshTable'];
  public $hideable = 'select';

  public function builder()
  {
    return DataSiswa::query()->whereHas('kelas', function ($query) {
      $query->whereIn('kelas_id', [$this->params['kelas_id']])->whereHas('ujian', function ($query) {
        $query->where('data_ujian.id', $this->params['ujian_id']);
      });
    });
  }

  public function columns()
  {
    return [
      Column::name('id')->label('No.'),
      Column::name('nis')->label('nis')->searchable(),
      Column::name('nama_siswa')->label('Nama Siswa')->searchable(),

      Column::callback(['id'], function ($id) {
        return view('crud-generator-components::action-button', [
          'id' => $id,
          'actions' => [
            [
              'type' => 'link',
              'params' => ['ujian_id' => $this->params['ujian_id'], 'siswa_id' => $id],
              'label' => 'Lihat Jawaban',
              'route' => 'list-jawaban-ujian-siswa'
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
