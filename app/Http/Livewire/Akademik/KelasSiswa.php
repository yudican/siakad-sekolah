<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataKelas;
use Livewire\Component;

class KelasSiswa extends Component
{
    public $kelas_id;
    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataKelasById'];

    public function render()
    {
        return view('livewire.akademik.kelas-siswa', [
            'data_kelas' => DataKelas::all(),
        ])->layout(config('crud-generator.layout'));;
    }

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function toggleForm($form)
    {
        $this->_reset();
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function getDataDataKelasById(String $kelas_id)
    {
        $this->kelas_id =  $kelas_id;
        $this->emit('setKelasId', $kelas_id);
        $this->emit('setSelected', $kelas_id);
        $this->form_active = true;
    }

    public function handleChangeKelas($type, $value)
    {
        $this->emit('setSelected', $value);
    }

    public function store()
    {
        $this->validate([
            'kelas_id' => 'required',
        ]);

        $this->emit('storeSiswa', $this->kelas_id);
    }

    public function _reset()
    {
        $this->kelas_id = null;
        $this->form_active = false;
        $this->form = true;
        $this->update_mode = false;
        $this->modal = false;
    }
}
