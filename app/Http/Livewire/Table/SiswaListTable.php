<?php

namespace App\Http\Livewire\Table;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class SiswaListTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'storeSiswa', 'setSelected'];
    public $table_name = 'tbl_data_siswas';

    public function builder()
    {
        return DataSiswa::query()->whereDoesntHave('kelas');
    }

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::name('id')->label('No.'),
            Column::name('nis')->label('Nis')->searchable(),
            Column::name('nama_siswa')->label('Nama Siswa')->searchable(),
        ];
    }

    public function storeSiswa($kelas_id)
    {
        $kelas  = DataKelas::find($kelas_id);
        if ($kelas) {
            $kelas->siswa()->sync($this->selected);
            $this->emit('refreshTable');
            $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        }
    }

    public function setSelected($kelas_id)
    {
        $kelas  = DataKelas::find($kelas_id);
        if ($kelas) {
            $selecteds = $kelas->siswa()->pluck('data_siswas.id')->toArray();
            $data = [];
            foreach ($selecteds as $key => $value) {
                $data[] = (string) $value;
            }
            $this->selected = $data;
            $this->forgetComputed();
        }
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
