<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataKelas;
use App\Models\DataMateri;
use App\Models\DataSiswa;
use App\Models\DataTugas;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTugasController extends Component
{
    use WithFileUploads;
    public $data_tuga_id;
    public $deskripsi_tugas;
    public $due_date;
    public $file;
    public $kelas_id;
    public $materi_id;
    public $nama_tugas;
    public $file_path;


    public $tab = 'update';
    public $tabDetail = 'list';
    public $row;
    public $tugas;
    public $pengumpulanTugas = [];
    public $nilai;
    public $catatan;


    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataTugasById', 'getDataTugasId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-tuga', [
            'kelass' => DataKelas::all(),
            'materis' => DataMateri::all(),
        ])->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();
        try {
            DB::beginTransaction();
            $data = [
                'deskripsi_tugas'  => $this->deskripsi_tugas,
                'due_date'  => $this->due_date,
                'kelas_id'  => $this->kelas_id,
                'materi_id'  => $this->materi_id,
                'nama_tugas'  => $this->nama_tugas
            ];

            if ($this->file_path) {
                $file = $this->file_path->store('upload/tugas', 'public');
                $data = ['file' => $file];
            }

            $siswas = DataSiswa::whereHas('kelas', function ($query) {
                $query->where('data_kelas.id', $this->kelas_id);
            })->get();
            $tugas = DataTugas::create($data);
            foreach ($siswas as $key => $siswa) {
                $tugas->pengumpulanTugas()->create([
                    'siswa_id' => $siswa->id,
                    'nilai' => 0,
                    'status' => 0,
                ]);
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
            'deskripsi_tugas'  => $this->deskripsi_tugas,
            'due_date'  => $this->due_date,
            'file'  => $this->file,
            'kelas_id'  => $this->kelas_id,
            'materi_id'  => $this->materi_id,
            'nama_tugas'  => $this->nama_tugas
        ];
        $row = DataTugas::find($this->data_tuga_id);


        if ($this->file_path) {
            $file = $this->file_path->store('upload/tugas', 'public');
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
        DataTugas::find($this->data_tuga_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'deskripsi_tugas'  => 'required',
            'due_date'  => 'required',
            'kelas_id'  => 'required',
            'materi_id'  => 'required',
            'nama_tugas'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataTugasById($data_tuga_id, $type)
    {
        $this->_reset();
        $row = DataTugas::find($data_tuga_id);
        $this->data_tuga_id = $row->id;
        $this->tab = $type;
        if ($type == 'detail') {
            $tugas = PengumpulanTugas::where('tugas_id', $row->id)->where('siswa_id', auth()->user()->siswa->id)->first();
            $this->row = $row;
            if ($tugas) {
                $this->tugas = $tugas;
            }
        } else if ($type == 'pengumpulan') {
            $this->pengumpulanTugas = $row->pengumpulanTugas;
        } else {
            $this->deskripsi_tugas = $row->deskripsi_tugas;
            $this->due_date = date('Y-m-d', strtotime($row->due_date));
            $this->file = $row->file;
            $this->kelas_id = $row->kelas_id;
            $this->materi_id = $row->materi_id;
            $this->nama_tugas = $row->nama_tugas;
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

    public function detailPengumpulan($tugas_id)
    {
        $tugas = PengumpulanTugas::find($tugas_id);
        $this->tugas = $tugas;
        $this->tabDetail = 'detail';
    }

    public function getDataTugasId($data_tuga_id)
    {
        $row = DataTugas::find($data_tuga_id);
        $this->data_tuga_id = $row->id;
        $this->emit('showModalConfirm');
    }

    public function simpanNilai()
    {
        $row = PengumpulanTugas::find($this->tugas->id);
        if ($row) {
            $row->update(['nilai' => $this->nilai, 'status' => '1']);
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Nilai Berhasil Disimpan']);
        }

        return $this->emit('showAlertError', ['msg' => 'Nilai Gagal Disimpan']);
    }

    public function uploadJawaban()
    {
        $this->validate(['file_path' => 'required']);
        $row = PengumpulanTugas::where('tugas_id', $this->data_tuga_id)->where('siswa_id', auth()->user()->siswa->id)->first();

        if ($row) {
            $data = ['status' => '2', 'tanggal_kirim' => date('Y-m-d H:i:s'), 'catatan' => $this->catatan];
            if ($this->file_path) {
                $file = $this->file_path->store('upload/tugas/jawaban', 'public');
                $data['file'] = $file;
            }
            $row->update($data);
            $this->_reset();
            $this->emit('showModalUpload', 'hide');
            return $this->emit('showAlert', ['msg' => 'Tugas Berhasil Dikirim']);
        }

        return $this->emit('showAlertError', ['msg' => 'Tugas Gagal Dikirim']);
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

    public function showModalUpload()
    {
        $row = PengumpulanTugas::where('tugas_id', $this->data_tuga_id)->where('siswa_id', auth()->user()->siswa->id)->first();
        if ($row) {
            if ($row->status == 1) {
                return $this->emit('showAlert', ['msg' => 'Tugas Sudah Dinilai']);
            }
        }
        $this->emit('showModalUpload', 'show');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->data_tuga_id = null;
        $this->deskripsi_tugas = null;
        $this->due_date = null;
        $this->file_path = null;
        $this->kelas_id = null;
        $this->materi_id = null;
        $this->tab = 'update';
        $this->tabDetail = 'list';
        $this->tugas = null;
        $this->row = null;
        $this->nilai = null;
        $this->catatan = null;
        $this->pengumpulanTugas = [];
        $this->nama_tugas = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
