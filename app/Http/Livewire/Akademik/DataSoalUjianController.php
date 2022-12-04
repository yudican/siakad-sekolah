<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataPilihanJawaban;
use App\Models\DataSoalUjian;
use App\Models\DataUjian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataSoalUjianController extends Component
{
    use WithFileUploads;
    public $data_soal_ujian_id;
    public $data_ujian_id;
    public $nama_soal;
    public $gambar_soal;
    public $gambar_soal_path;


    public $route_name = null;
    public $kunci_jawaban = [];
    public $nama_jawaban = [];
    public $pilihan_jawabans = [null, null, null, null, null];

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;
    public $type_soal = 'pg';

    protected $listeners = ['getDataDataSoalUjianById', 'getDataSoalUjianId'];

    public function mount($data_ujian_id)
    {
        $this->route_name = request()->route()->getName();
        $this->data_ujian_id = $data_ujian_id;
        $ujian = DataUjian::find($data_ujian_id);

        if ($ujian) {
            $this->type_soal = $ujian->jenis_soal;
        }
    }

    public function render()
    {
        return view('livewire.akademik.data-soal-ujian')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();

        try {
            DB::beginTransaction();
            $data = [
                'data_ujian_id'  => $this->data_ujian_id,
                'nama_soal'  => $this->nama_soal,
            ];

            if ($this->gambar_soal_path) {
                $gambar_soal = $this->gambar_soal_path->store('upload', 'public');
                $data['gambar_soal'] = $gambar_soal;
            }

            $soal = DataSoalUjian::create($data);
            if ($this->type_soal == 'pg') {
                foreach ($this->pilihan_jawabans as $key => $pilihan_jawaban) {
                    $soal->dataPilihanJawaban()->create([
                        'pilihan_jawaban' => $this->nama_jawaban[$key],
                        'kunci_jawaban' => in_array($key, $this->kunci_jawaban) ? true : false,
                    ]);
                }
            }

            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan']);
        }
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'data_ujian_id'  => $this->data_ujian_id,
            'nama_soal'  => $this->nama_soal,
        ];
        $row = DataSoalUjian::find($this->data_soal_ujian_id);


        if ($this->gambar_soal_path) {
            $gambar_soal = $this->gambar_soal_path->store('upload', 'public');
            $data = ['gambar_soal' => $gambar_soal];
            if (Storage::exists('public/' . $this->gambar_soal)) {
                Storage::delete('public/' . $this->gambar_soal);
            }
        }

        $row->update($data);

        if ($this->type_soal == 'pg') {
            foreach ($this->pilihan_jawabans as $key => $pilihan_jawaban) {
                DataPilihanJawaban::updateOrCreate(['id' => $pilihan_jawaban], [
                    'pilihan_jawaban' => $this->nama_jawaban[$key],
                    'kunci_jawaban' => in_array($key, $this->kunci_jawaban) ? true : false,
                ]);
            }
        }
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataSoalUjian::find($this->data_soal_ujian_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            // 'data_ujian_id'  => 'required',
            'nama_soal'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataSoalUjianById($data_soal_ujian_id)
    {
        $this->_reset();
        $row = DataSoalUjian::find($data_soal_ujian_id);
        $this->data_soal_ujian_id = $row->id;
        $this->data_ujian_id = $row->data_ujian_id;
        $this->nama_soal = $row->nama_soal;
        $this->gambar_soal = $row->gambar_soal;
        $this->gambar_soal_path = $row->gambar_soal;
        $this->pilihan_jawabans = $row->dataPilihanJawaban()->pluck('data_pilihan_jawabans.id')->toArray();
        $this->nama_jawaban = $row->dataPilihanJawaban()->pluck('pilihan_jawaban')->toArray();
        foreach ($row->dataPilihanJawaban as $key => $value) {
            if ($value->kunci_jawaban == true) {
                $this->kunci_jawaban = [$key];
            }
        }

        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataSoalUjianId($data_soal_ujian_id)
    {
        $row = DataSoalUjian::find($data_soal_ujian_id);
        $this->data_soal_ujian_id = $row->id;
    }

    public function toggleForm($form)
    {
        $this->_reset();
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->_reset();
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->data_soal_ujian_id = null;
        $this->nama_soal = null;
        $this->gambar_soal_path = null;
        $this->kunci_jawaban = [];
        $this->nama_jawaban = [];
        $this->pilihan_jawabans = [null, null, null, null, null];
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
