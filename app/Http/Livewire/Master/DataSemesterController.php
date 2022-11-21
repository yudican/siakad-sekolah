<?php

namespace App\Http\Livewire\Master;

use App\Models\DataSemester;
use Livewire\Component;


class DataSemesterController extends Component
{
    
    public $data_semester_id;
    public $kode_semester;
public $nama_semester;
public $status_semester;
    
   

    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataSemesterById', 'getDataSemesterId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.data-semester')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['kode_semester'  => $this->kode_semester,
'nama_semester'  => $this->nama_semester,
'status_semester'  => $this->status_semester];

        DataSemester::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['kode_semester'  => $this->kode_semester,
'nama_semester'  => $this->nama_semester,
'status_semester'  => $this->status_semester];
        $row = DataSemester::find($this->data_semester_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataSemester::find($this->data_semester_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'kode_semester'  => 'required',
'nama_semester'  => 'required',
'status_semester'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataSemesterById($data_semester_id)
    {
        $this->_reset();
        $row = DataSemester::find($data_semester_id);
        $this->data_semester_id = $row->id;
        $this->kode_semester = $row->kode_semester;
$this->nama_semester = $row->nama_semester;
$this->status_semester = $row->status_semester;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataSemesterId($data_semester_id)
    {
        $row = DataSemester::find($data_semester_id);
        $this->data_semester_id = $row->id;
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
        $this->data_semester_id = null;
        $this->kode_semester = null;
$this->nama_semester = null;
$this->status_semester = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
