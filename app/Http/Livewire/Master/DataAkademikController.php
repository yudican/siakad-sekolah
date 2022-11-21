<?php

namespace App\Http\Livewire\Master;

use App\Models\DataAkademik;
use App\Models\DataSemester;
use Livewire\Component;


class DataAkademikController extends Component
{

    public $data_akademik_id;
    public $data_semester_id;
    public $kode_akademik;
    public $nama_akademik;
    public $status_akademik;



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataAkademikById', 'getDataAkademikId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.data-akademik', [
            'semesters' => DataSemester::all()
        ])->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'data_semester_id'  => $this->data_semester_id,
            'kode_akademik'  => $this->kode_akademik,
            'nama_akademik'  => $this->nama_akademik,
            'status_akademik'  => $this->status_akademik
        ];

        DataAkademik::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'data_semester_id'  => $this->data_semester_id,
            'kode_akademik'  => $this->kode_akademik,
            'nama_akademik'  => $this->nama_akademik,
            'status_akademik'  => $this->status_akademik
        ];
        $row = DataAkademik::find($this->data_akademik_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataAkademik::find($this->data_akademik_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'data_semester_id'  => 'required',
            'kode_akademik'  => 'required',
            'nama_akademik'  => 'required',
            'status_akademik'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataAkademikById($data_akademik_id)
    {
        $this->_reset();
        $row = DataAkademik::find($data_akademik_id);
        $this->data_akademik_id = $row->id;
        $this->data_semester_id = $row->data_semester_id;
        $this->kode_akademik = $row->kode_akademik;
        $this->nama_akademik = $row->nama_akademik;
        $this->status_akademik = $row->status_akademik;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataAkademikId($data_akademik_id)
    {
        $row = DataAkademik::find($data_akademik_id);
        $this->data_akademik_id = $row->id;
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
        $this->data_akademik_id = null;
        $this->data_semester_id = null;
        $this->kode_akademik = null;
        $this->nama_akademik = null;
        $this->status_akademik = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
