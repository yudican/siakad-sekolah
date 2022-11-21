<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataAkademik;
use App\Models\DataGuru;
use App\Models\DataMapel;
use App\Models\DataMateri;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataMateriController extends Component
{
    use WithFileUploads;
    public $data_materi_id;
    public $akademik_id;
    public $deskripsi_materi;
    public $file;
    public $guru_id;
    public $link;
    public $mapel_id;
    public $nama_materi;
    public $file_path;


    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataMateriById', 'getDataMateriId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-materi', [
            'akademiks' => DataAkademik::all(),
            'mapels' => DataMapel::all(),
            'gurus' => DataGuru::all(),
        ])->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        $data = [
            'akademik_id'  => $this->akademik_id,
            'deskripsi_materi'  => $this->deskripsi_materi,
            'guru_id'  => $this->guru_id,
            'link'  => $this->link,
            'mapel_id'  => $this->mapel_id,
            'nama_materi'  => $this->nama_materi
        ];

        if ($this->file_path) {
            $file = $this->file_path->store('upload/materi', 'public');
            $data = ['file' => $file];
        }

        DataMateri::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'akademik_id'  => $this->akademik_id,
            'deskripsi_materi'  => $this->deskripsi_materi,
            'file'  => $this->file,
            'guru_id'  => $this->guru_id,
            'link'  => $this->link,
            'mapel_id'  => $this->mapel_id,
            'nama_materi'  => $this->nama_materi
        ];
        $row = DataMateri::find($this->data_materi_id);


        if ($this->file_path) {
            $file = $this->file_path->store('upload/materi', 'public');
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
        DataMateri::find($this->data_materi_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'akademik_id'  => 'required',
            'deskripsi_materi'  => 'required',
            'guru_id'  => 'required',
            'mapel_id'  => 'required',
            'nama_materi'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataMateriById($data_materi_id)
    {
        $this->_reset();
        $row = DataMateri::find($data_materi_id);
        $this->data_materi_id = $row->id;
        $this->akademik_id = $row->akademik_id;
        $this->deskripsi_materi = $row->deskripsi_materi;
        $this->file = $row->file;
        $this->guru_id = $row->guru_id;
        $this->link = $row->link;
        $this->mapel_id = $row->mapel_id;
        $this->nama_materi = $row->nama_materi;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataMateriId($data_materi_id)
    {
        $row = DataMateri::find($data_materi_id);
        $this->data_materi_id = $row->id;
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
        $this->data_materi_id = null;
        $this->akademik_id = null;
        $this->deskripsi_materi = null;
        $this->file_path = null;
        $this->guru_id = null;
        $this->link = null;
        $this->mapel_id = null;
        $this->nama_materi = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
