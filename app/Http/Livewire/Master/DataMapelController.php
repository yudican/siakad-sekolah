<?php

namespace App\Http\Livewire\Master;

use App\Models\DataMapel;
use Livewire\Component;


class DataMapelController extends Component
{
    
    public $data_mapel_id;
    public $kode_mapel;
public $nama_mapel;
public $status_mapel;
    
   

    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataMapelById', 'getDataMapelId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.data-mapel')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['kode_mapel'  => $this->kode_mapel,
'nama_mapel'  => $this->nama_mapel,
'status_mapel'  => $this->status_mapel];

        DataMapel::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['kode_mapel'  => $this->kode_mapel,
'nama_mapel'  => $this->nama_mapel,
'status_mapel'  => $this->status_mapel];
        $row = DataMapel::find($this->data_mapel_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataMapel::find($this->data_mapel_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_mapel'  => 'required',
'nama_mapel'  => 'required',
'status_mapel'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataMapelById($data_mapel_id)
    {
        $this->_reset();
        $row = DataMapel::find($data_mapel_id);
        $this->data_mapel_id = $row->id;
        $this->kode_mapel = $row->kode_mapel;
$this->nama_mapel = $row->nama_mapel;
$this->status_mapel = $row->status_mapel;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataMapelId($data_mapel_id)
    {
        $row = DataMapel::find($data_mapel_id);
        $this->data_mapel_id = $row->id;
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
        $this->data_mapel_id = null;
        $this->kode_mapel = null;
$this->nama_mapel = null;
$this->status_mapel = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
