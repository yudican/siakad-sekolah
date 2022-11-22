<?php

namespace App\Http\Livewire;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataUjian;
use Livewire\Component;

class JawabanUjianSiswaController extends Component
{
    public $ujian_id;
    public $soal_id;
    public $siswa_id;
    public $jenis_soal;

    public $jawaban_essay;
    public $jawaban_pg;

    public function mount($ujian_id, $siswa_id)
    {
        $ujian = DataUjian::find($ujian_id);
        $this->jenis_soal = $ujian->jenis_soal;
        $this->siswa_id = $siswa_id;
        if ($ujian->jenis_soal == 'pg') {
            $this->jawaban_pg = DataJawabanUjian::query()->where('siswa_id', $this->siswa_id)->where('data_ujian_id', $this->ujian_id)->get();
        }

        $this->jawaban_essay =  DataJawabaEssay::query()->where('data_siswa_id', $this->siswa_id)->where('data_ujian_id', $this->ujian_id)->get();
    }
    public function render()
    {
        return view('livewire.jawaban-ujian-siswa');
    }
}
