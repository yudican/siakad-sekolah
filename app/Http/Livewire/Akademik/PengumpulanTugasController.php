<?php

namespace App\Http\Livewire\Akademik;

use App\Models\PengumpulanTugas;
use Livewire\Component;
use Livewire\WithFileUploads;

class PengumpulanTugasController extends Component
{
    use WithFileUploads;
    public $pengumpulan_tuga_id;
    public $catatan;
    public $file;
    public $nilai;
    public $siswa_id;
    public $status;
    public $tugas_id;
    public $file_path;


    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataPengumpulanTugasById', 'getPengumpulanTugasId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.pengumpulan-tuga')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        $file = $this->file_path->store('upload', 'public');
        $data = [
            'catatan'  => $this->catatan,
            'file'  => $file,
            'nilai'  => $this->nilai,
            'siswa_id'  => $this->siswa_id,
            'status'  => $this->status,
            'tugas_id'  => $this->tugas_id
        ];

        PengumpulanTugas::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'catatan'  => $this->catatan,
            'file'  => $this->file,
            'nilai'  => $this->nilai,
            'siswa_id'  => $this->siswa_id,
            'status'  => $this->status,
            'tugas_id'  => $this->tugas_id
        ];
        $row = PengumpulanTugas::find($this->pengumpulan_tuga_id);


        if ($this->file_path) {
            $file = $this->file_path->store('upload', 'public');
            $data = ['file' => $file];
            if (Storage::exists('public/' . $this->file)) {
                Storage::delete('public/' . $this->file);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        PengumpulanTugas::find($this->pengumpulan_tuga_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'catatan'  => 'required',
            'nilai'  => 'required',
            'siswa_id'  => 'required',
            'status'  => 'required',
            'tugas_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataPengumpulanTugasById($pengumpulan_tuga_id)
    {
        $this->_reset();
        $row = PengumpulanTugas::find($pengumpulan_tuga_id);
        $this->pengumpulan_tuga_id = $row->id;
        $this->catatan = $row->catatan;
        $this->file = $row->file;
        $this->nilai = $row->nilai;
        $this->siswa_id = $row->siswa_id;
        $this->status = $row->status;
        $this->tugas_id = $row->tugas_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getPengumpulanTugasId($pengumpulan_tuga_id)
    {
        $row = PengumpulanTugas::find($pengumpulan_tuga_id);
        $this->pengumpulan_tuga_id = $row->id;
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
        $this->pengumpulan_tuga_id = null;
        $this->catatan = null;
        $this->file_path = null;
        $this->nilai = null;
        $this->siswa_id = null;
        $this->status = null;
        $this->tugas_id = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
