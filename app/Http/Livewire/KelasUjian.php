<?php

namespace App\Http\Livewire;

use Livewire\Component;

class KelasUjian extends Component
{
    public $ujian_id;

    public function mount($ujian_id)
    {
        $this->ujian_id = $ujian_id;
    }

    public function render()
    {
        return view('livewire.kelas-ujian');
    }
}
