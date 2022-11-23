<?php

namespace App\Exports;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataSiswa;
use App\Models\DataUjian;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiSiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $kelas_id;
    protected $ujian_id;
    protected $title;
    public function __construct($kelas_id, $ujian_id, $title = 'ExportNilai')
    {
        $this->kelas_id = $kelas_id;
        $this->ujian_id = $ujian_id;
        $this->title = $title;
    }

    public function query()
    {
        return DataSiswa::query()->whereHas('kelas', function ($query) {
            $query->where('kelas_id', $this->kelas_id)->whereHas('ujian', function ($query) {
                $query->where('data_ujian.id', $this->ujian_id);
            });
        });
    }

    public function map($row): array
    {
        $user_id = auth()->user()->id;
        $ujian_siswa = DB::table('siswa_ujian')->where([
            'data_ujian_id' => $this->ujian_id,
            'siswa_id' => $row->id,
        ])->first();
        $ujian = DataUjian::find($this->ujian_id);
        $nilai = 0;
        if ($ujian_siswa) {
            if ($ujian->jenis_ujian == 'pg') {
                // hitung nilai
                $benar = 0;
                $salah = 0;
                $jawabans = DataJawabanUjian::where('data_ujian_id', $this->ujian_id)->where('siswa_id', $user_id)->get();

                foreach ($jawabans as $jawaban) {
                    if ($jawaban->status) {
                        $benar++;
                    } else {
                        $salah++;
                    }
                }

                $nilai = $benar;
            }

            $jawabans = DataJawabaEssay::where('data_ujian_id', $this->ujian_id)->where('data_siswa_id', $user_id)->sum('nilai');

            $nilai = "$jawabans";
        }
        return [
            $row->nis,
            $row->nama_siswa,
            $nilai,
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Nilai',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}
