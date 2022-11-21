<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataKelas;
use Livewire\Component;

class KelasSiswa extends Component
{
    public $kelas_id = null;
    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

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
