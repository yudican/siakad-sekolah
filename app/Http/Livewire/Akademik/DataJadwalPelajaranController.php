<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataAkademik;
use App\Models\DataGuru;
use App\Models\DataJadwalPelajaran;
use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataMapel;
use Livewire\Component;


class DataJadwalPelajaranController extends Component
{

    public $data_jadwal_pelajaran_id;
    public $akademik_id;
    public $kelas_id;
    public $mapel_id;
    public $guru_id;
    public $jurusan_id;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;



    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataJadwalPelajaranById', 'getDataJadwalPelajaranId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-jadwal-pelajaran', [
            'akademiks' => DataAkademik::all(),
            'kelass' => DataKelas::all(),
            'mapels' => DataMapel::all(),
            'gurus' => DataGuru::all(),
            'jurusans' => DataJurusan::all(),
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
            'jurusan_id'  => $this->jurusan_id,
            'hari'  => $this->hari,
            'jam_mulai'  => $this->jam_mulai,
            'jam_selesai'  => $this->jam_selesai
        ];

        DataJadwalPelajaran::create($data);

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
            'jurusan_id'  => $this->jurusan_id,
            'hari'  => $this->hari,
            'jam_mulai'  => $this->jam_mulai,
            'jam_selesai'  => $this->jam_selesai
        ];
        $row = DataJadwalPelajaran::find($this->data_jadwal_pelajaran_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataJadwalPelajaran::find($this->data_jadwal_pelajaran_id)->delete();

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
            'jurusan_id'  => 'required',
            'hari'  => 'required',
            'jam_mulai'  => 'required',
            'jam_selesai'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataJadwalPelajaranById($data_jadwal_pelajaran_id)
    {
        $this->_reset();
        $row = DataJadwalPelajaran::find($data_jadwal_pelajaran_id);
        $this->data_jadwal_pelajaran_id = $row->id;
        $this->akademik_id = $row->akademik_id;
        $this->kelas_id = $row->kelas_id;
        $this->mapel_id = $row->mapel_id;
        $this->guru_id = $row->guru_id;
        $this->jurusan_id = $row->jurusan_id;
        $this->hari = $row->hari;
        $this->jam_mulai = $row->jam_mulai;
        $this->jam_selesai = $row->jam_selesai;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataJadwalPelajaranId($data_jadwal_pelajaran_id)
    {
        $row = DataJadwalPelajaran::find($data_jadwal_pelajaran_id);
        $this->data_jadwal_pelajaran_id = $row->id;
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
        $this->data_jadwal_pelajaran_id = null;
        $this->akademik_id = null;
        $this->kelas_id = null;
        $this->mapel_id = null;
        $this->guru_id = null;
        $this->jurusan_id = null;
        $this->hari = null;
        $this->jam_mulai = null;
        $this->jam_selesai = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
