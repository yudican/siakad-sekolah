<?php

namespace App\Http\Livewire;

use App\Exports\NilaiSiswaExport;
use App\Models\DataKelas;
use App\Models\DataUjian;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ListUjianSiswaController extends Component
{
    public $ujian_id;
    public $kelas_id;

    public function mount($kelas_id, $ujian_id)
    {
        $this->kelas_id = $kelas_id;
        $this->ujian_id = $ujian_id;
    }

    public function render()
    {
        return view('livewire.list-ujian-siswa-controller');
    }

    public function exportNilai()
    {
        $kelas = DataKelas::find($this->kelas_id);
        return Excel::download(new NilaiSiswaExport($this->kelas_id, $this->ujian_id), "Nilai Ujian {$kelas->nama_kelas} {$kelas->kode_kelas}.xlsx");
    }
}
