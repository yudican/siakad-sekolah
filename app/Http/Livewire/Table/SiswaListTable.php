<?php

namespace App\Http\Livewire\Table;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use Mediconesystems\LivewireDatatables\Column;
use Yudican\LaravelCrudGenerator\Livewire\Table\LivewireDatatable;

class SiswaListTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'storeSiswa', 'setSelected', 'setKelasId'];
    public $table_name = 'tbl_data_siswas';
    public $kelas_id = null;
    public function builder()
    {
        if ($this->kelas_id) {
            return DataSiswa::query()->whereHas('kelas', function ($query) {
                $query->where('data_kelas.id', $this->kelas_id);
            })->orWhereDoesntHave('kelas');
        }
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
            $selected = [];
            foreach ($this->selected as $key => $value) {
                if ($value) {
                    $selected[$value] = $value;
                }
            }
            $kelas->siswa()->sync($selected);
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
                $data[$value] = (string) $value;
            }
            $this->selected = $data;
        }
    }

    public function setKelasId($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }
}
