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

    public $benar = 0;
    public $salah = 0;

    public $jawaban_essay;
    public $jawaban_pg;

    public function mount($ujian_id, $siswa_id)
    {
        $ujian = DataUjian::find($ujian_id);
        $this->jenis_soal = $ujian->jenis_soal;
        $this->siswa_id = $siswa_id;
        if ($ujian->jenis_soal == 'pg') {
            $jawaban_pg = DataJawabanUjian::query()->where('siswa_id', $this->siswa_id)->where('data_ujian_id', $this->ujian_id)->get();
            $benar = 0;
            $salah = 0;
            foreach ($jawaban_pg as $key => $value) {
                $benar = $value->status == 1 ? $benar + 1 : 0;
                $salah = $value->status == 0 ? $salah + 1 : 0;
            }

            $this->jawaban_pg = $jawaban_pg;
        }

        $this->jawaban_essay =  DataJawabaEssay::query()->where('data_siswa_id', $this->siswa_id)->where('data_ujian_id', $this->ujian_id)->get();
    }
    public function render()
    {
        return view('livewire.jawaban-ujian-siswa');
    }
}
