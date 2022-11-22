<?php

namespace App\Http\Livewire;

use App\Models\DataUjian;
use Livewire\Component;

class ListUjianSiswaController extends Component
{
    public $ujian_id;
    public $kelas_id;

    public function mount($ujian_id)
    {
        $ujian = DataUjian::find($ujian_id);
        $this->kelas_id = $ujian->kelas_id;
        $this->ujian_id = $ujian_id;
    }

    public function render()
    {
        return view('livewire.list-ujian-siswa-controller');
    }
}
