<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;
use App\Models\DataPilihanJawaban;
use App\Models\DataSoalUjian;
use App\Models\DataUjian;
use App\Models\WaktuUjianSiswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UjianSiswaController extends Component
{

    public  $soal;
    public  $soal_id;
    public  $ujian_id;
    public  $soals;
    public  $countdown;
    public  $countDowntimer;
    public  $jawaban;
    public  $nilai;
    public  $type_soal = 'pg';
    public  $pilihan_jawaban = [];
    public  $soal_jawaban = [];

    public function mount($ujian_id)
    {
        $this->ujian_id = $ujian_id;
        $this->soals = DataSoalUjian::where('data_ujian_id', $ujian_id)->get();
        if (count($this->soals) > 0) {
            $this->soal = DataSoalUjian::find($this->soals[0]->id);
            $this->type_soal = $this->soal->dataUjian->jenis_soal;
            $this->soal_id = $this->soals[0]->id;
            $jawabans = DataJawabanUjian::where('data_ujian_id', $ujian_id)->get();
            foreach ($jawabans as $key => $value) {
                $this->pilihan_jawaban[$value->data_pilihan_jawaban_id] = $value->data_pilihan_jawaban_id;
                $this->soal_jawaban[$value->data_soal_ujian_id] = $value->data_pilihan_jawaban_id;
            }

            $jawaban_essays = DataJawabaEssay::where('data_ujian_id', $ujian_id)->get();
            foreach ($jawaban_essays as $key => $value) {
                $this->jawaban[$value->data_soal_ujian_id] = $value->jawaban;
                $this->nilai[$value->data_soal_ujian_id] = $value->nilai;
            }
            $timer = WaktuUjianSiswa::where([
                'data_ujian_id' => $this->soal->data_ujian_id,
                'siswa_id' => auth()->user()->siswa->id,
            ])->first();

            $this->countdown = $timer ? $timer->sisa_waktu : $this->soal->dataUjian->waktu_pengerjaan;
        }
    }

    public function saveJawaban()
    {
        DataJawabaEssay::updateOrCreate([
            'data_soal_ujian_id' => $this->soal_id,
            'data_ujian_id' => $this->ujian_id,
            'data_siswa_id' => auth()->user()->siswa->id,
        ], [
            'jawaban' => $this->jawaban[$this->soal_id],
        ]);
        $this->loadDetail();
        $this->emit('showAlert', ['msg' => 'Jawaban berhasil disimpan']);
    }

    public function saveNilai()
    {
        DataJawabaEssay::updateOrCreate([
            'data_soal_ujian_id' => $this->soal_id,
            'data_ujian_id' => $this->ujian_id,
            'data_siswa_id' => auth()->user()->siswa->id,
        ], [
            'nilai' => $this->nilai,
        ]);

        $this->emit('showAlert', ['msg' => 'Jawaban berhasil disimpan']);
    }

    public function submitJawaban()
    {
        DB::table('siswa_ujian')->insert([
            'data_ujian_id' => $this->soal->data_ujian_id,
            'siswa_id' => auth()->user()->siswa->id,
        ]);

        WaktuUjianSiswa::updateOrCreate([
            'data_ujian_id' => $this->soal->data_ujian_id,
            'siswa_id' => auth()->user()->siswa->id,
        ], [
            'sisa_waktu' => 0
        ]);

        if ($this->type_soal == 'pg') {
            $soals = DataSoalUjian::where('data_ujian_id', $this->soal->data_ujian_id)->get();
            foreach ($soals as $key => $value) {
                $jawaban = DataJawabanUjian::where([
                    'data_ujian_id' => $this->soal->data_ujian_id,
                    'data_soal_ujian_id' => $value->id,
                    'siswa_id' => auth()->user()->siswa->id,
                ])->first();

                if (!$jawaban) {
                    DataJawabanUjian::create([
                        'data_ujian_id' => $this->soal->data_ujian_id,
                        'data_soal_ujian_id' => $value->id,
                        'siswa_id' => auth()->user()->siswa->id,
                        'is_answered' => 0,
                        'status' => 0
                    ]);
                }
            }
        }


        $this->emit('showAlert', ['msg' => 'Ujian Berhasil Disimpan']);
        return redirect(route('data-ujian'));
    }

    public function _reset()
    {
        $this->emit('showModalConfirm', 'hide');
    }

    public function loadDetail()
    {
        $detail = DataJawabaEssay::where([
            'data_soal_ujian_id' => $this->soal_id,
            'data_ujian_id' => $this->ujian_id,
            'data_siswa_id' => auth()->user()->siswa->id,
        ])->first();

        $this->jawaban[$this->soal_id] = $detail->jawaban;
        $this->nilai[$this->soal_id] = $detail->nilai;
    }

    public function render()
    {
        return view('livewire.akademik.ujian-siswa')->layout(config('crud-generator.layout'));
    }

    public function changeSoal($soal_id)
    {
        $this->soal_id = $soal_id;
        $this->soal = DataSoalUjian::find($soal_id);
    }

    public function handleAnswer($jawaban_id)
    {
        $jawaban = DataPilihanJawaban::find($jawaban_id);
        DataJawabanUjian::updateOrCreate(
            [
                'data_ujian_id' => $this->soal->data_ujian_id,
                'data_soal_ujian_id' => $this->soal_id,
                'siswa_id' => auth()->user()->siswa->id,
            ],
            [
                'data_pilihan_jawaban_id' => $jawaban_id,
                'status' => $jawaban && $jawaban->kunci_jawaban ? true : false,
                'is_answered' => 1,
            ]
        );
        unset($this->pilihan_jawaban[$this->soal_jawaban[$this->soal_id]]);
        $this->pilihan_jawaban[$jawaban_id] = $jawaban_id;
    }

    public function setTimeReamining($timer)
    {
        WaktuUjianSiswa::updateOrCreate([
            'data_ujian_id' => $this->soal->data_ujian_id,
            'siswa_id' => auth()->user()->siswa->id,
        ], [
            'sisa_waktu' => $timer
        ]);

        $this->countDowntimer = convertTime($timer);
    }

    public function finishUjian()
    {
        DB::table('siswa_ujian')->insert([
            'data_ujian_id' => $this->soal->data_ujian_id,
            'siswa_id' => auth()->user()->siswa->id,
        ]);

        WaktuUjianSiswa::updateOrCreate([
            'data_ujian_id' => $this->soal->data_ujian_id,
            'siswa_id' => auth()->user()->siswa->id,
        ], [
            'sisa_waktu' => 0
        ]);

        if ($this->type_soal == 'pg') {
            $soals = DataSoalUjian::where('data_ujian_id', $this->soal->data_ujian_id)->get();
            foreach ($soals as $key => $value) {
                $jawaban = DataJawabanUjian::where([
                    'data_ujian_id' => $this->soal->data_ujian_id,
                    'data_soal_ujian_id' => $value->id,
                    'siswa_id' => auth()->user()->siswa->id,
                ])->first();

                if (!$jawaban) {
                    DataJawabanUjian::create([
                        'data_ujian_id' => $this->soal->data_ujian_id,
                        'data_soal_ujian_id' => $value->id,
                        'siswa_id' => auth()->user()->siswa->id,
                        'is_answered' => 0,
                        'status' => 0
                    ]);
                }
            }
        }

        $this->emit('showAlert', ['msg' => 'Waktu Habis Ujian  Dianggap Selesai']);
        return redirect(route('data-ujian'));
    }

    public function confirmFinish()
    {
        $this->emit('showModalConfirm', 'show');
    }
}
