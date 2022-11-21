<?php

namespace App\Http\Livewire\Master;

use App\Models\DataAkademik;
use App\Models\DataGuru;
use App\Models\DataKelas;
use Livewire\Component;


class DataKelasController extends Component
{

    public $data_kela_id;
    public $kode_kelas;
    public $nama_kelas;
    public $guru_id;
    public $akademik_id;



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataKelasById', 'getDataKelasId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.data-kelas', [
            'data_guru' => DataGuru::all(),
            'data_akademik' => DataAkademik::all(),
        ])->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'kode_kelas'  => $this->kode_kelas,
            'nama_kelas'  => $this->nama_kelas,
            'guru_id'  => $this->guru_id,
            'akademik_id'  => $this->akademik_id,
        ];

        DataKelas::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'kode_kelas'  => $this->kode_kelas,
            'nama_kelas'  => $this->nama_kelas,
            'guru_id'  => $this->guru_id,
            'akademik_id'  => $this->akademik_id,
        ];
        $row = DataKelas::find($this->data_kela_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataKelas::find($this->data_kela_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_kelas'  => 'required',
            'nama_kelas'  => 'required',
            'guru_id'  => 'required',
            'akademik_id'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataKelasById($data_kela_id)
    {
        $this->_reset();
        $row = DataKelas::find($data_kela_id);
        $this->data_kela_id = $row->id;
        $this->kode_kelas = $row->kode_kelas;
        $this->nama_kelas = $row->nama_kelas;
        $this->guru_id = $row->guru_id;
        $this->akademik_id = $row->akademik_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataKelasId($data_kela_id)
    {
        $row = DataKelas::find($data_kela_id);
        $this->data_kela_id = $row->id;
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
        $this->data_kela_id = null;
        $this->kode_kelas = null;
        $this->nama_kelas = null;
        $this->guru_id = null;
        $this->akademik_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
