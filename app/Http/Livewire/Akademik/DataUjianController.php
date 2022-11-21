<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataAkademik;
use App\Models\DataGuru;
use App\Models\DataKelas;
use App\Models\DataMapel;
use App\Models\DataUjian;
use Livewire\Component;


class DataUjianController extends Component
{

    public $data_ujian_id;
    public $akademik_id;
    public $kelas_id;
    public $mapel_id;
    public $guru_id;
    public $tanggal_ujian;
    public $waktu_ujian;
    public $waktu_pengerjaan;
    public $jenis_ujian;
    public $jenis_soal;
    public $keterangan;



    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataUjianById', 'getDataUjianId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-ujian', [
            'akademiks' => DataAkademik::all(),
            'kelass' => DataKelas::all(),
            'mapels' => DataMapel::all(),
            'gurus' => DataGuru::all(),
        ])->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'akademik_id'  => $this->akademik_id,
            'kelas_id'  => $this->kelas_id,
            'mapel_id'  => $this->mapel_id,
            'guru_id'  => $this->guru_id,
            'tanggal_ujian'  => $this->tanggal_ujian . ' ' . $this->waktu_ujian,
            'waktu_ujian'  => $this->waktu_ujian,
            'waktu_pengerjaan'  => $this->waktu_pengerjaan * 60,
            'jenis_ujian'  => $this->jenis_ujian,
            'jenis_soal'  => $this->jenis_soal,
            'keterangan'  => $this->keterangan
        ];

        DataUjian::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'akademik_id'  => $this->akademik_id,
            'kelas_id'  => $this->kelas_id,
            'mapel_id'  => $this->mapel_id,
            'guru_id'  => $this->guru_id,
            'tanggal_ujian'  => $this->tanggal_ujian,
            'waktu_ujian'  => $this->waktu_ujian,
            'waktu_pengerjaan'  => $this->waktu_pengerjaan,
            'jenis_ujian'  => $this->jenis_ujian,
            'jenis_soal'  => $this->jenis_soal,
            'keterangan'  => $this->keterangan
        ];
        $row = DataUjian::find($this->data_ujian_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataUjian::find($this->data_ujian_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'akademik_id'  => 'required',
            'kelas_id'  => 'required',
            'mapel_id'  => 'required',
            'guru_id'  => 'required',
            'tanggal_ujian'  => 'required',
            'waktu_ujian'  => 'required',
            'waktu_pengerjaan'  => 'required',
            'jenis_ujian'  => 'required',
            'jenis_soal'  => 'required',
            'keterangan'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataUjianById($data_ujian_id)
    {
        $this->_reset();
        $row = DataUjian::find($data_ujian_id);
        $this->data_ujian_id = $row->id;
        $this->akademik_id = $row->akademik_id;
        $this->kelas_id = $row->kelas_id;
        $this->mapel_id = $row->mapel_id;
        $this->guru_id = $row->guru_id;
        $this->tanggal_ujian = $row->tanggal_ujian;
        $this->waktu_ujian = $row->waktu_ujian;
        $this->waktu_pengerjaan = $row->waktu_pengerjaan;
        $this->jenis_ujian = $row->jenis_ujian;
        $this->jenis_soal = $row->jenis_soal;
        $this->keterangan = $row->keterangan;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataUjianId($data_ujian_id)
    {
        $row = DataUjian::find($data_ujian_id);
        $this->data_ujian_id = $row->id;
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
        $this->data_ujian_id = null;
        $this->akademik_id = null;
        $this->kelas_id = null;
        $this->mapel_id = null;
        $this->guru_id = null;
        $this->tanggal_ujian = null;
        $this->waktu_ujian = null;
        $this->waktu_pengerjaan = null;
        $this->jenis_ujian = null;
        $this->jenis_soal = null;
        $this->keterangan = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
