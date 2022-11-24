<?php

namespace App\Http\Livewire\Master;

use App\Models\DataJurusan;
use Livewire\Component;


class DataJurusanController extends Component
{
    
    public $data_jurusan_id;
    public $kode_jurusan;
public $nama_jurusan;
    
   

    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataJurusanById', 'getDataJurusanId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.data-jurusan')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['kode_jurusan'  => $this->kode_jurusan,
'nama_jurusan'  => $this->nama_jurusan];

        DataJurusan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['kode_jurusan'  => $this->kode_jurusan,
'nama_jurusan'  => $this->nama_jurusan];
        $row = DataJurusan::find($this->data_jurusan_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataJurusan::find($this->data_jurusan_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_jurusan'  => 'required',
'nama_jurusan'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataJurusanById($data_jurusan_id)
    {
        $this->_reset();
        $row = DataJurusan::find($data_jurusan_id);
        $this->data_jurusan_id = $row->id;
        $this->kode_jurusan = $row->kode_jurusan;
$this->nama_jurusan = $row->nama_jurusan;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataJurusanId($data_jurusan_id)
    {
        $row = DataJurusan::find($data_jurusan_id);
        $this->data_jurusan_id = $row->id;
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
        $this->data_jurusan_id = null;
        $this->kode_jurusan = null;
$this->nama_jurusan = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
