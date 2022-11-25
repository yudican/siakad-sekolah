<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataGuru;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class DataGuruController extends Component
{

    public $data_guru_id;
    public $user_id;
    public $nip;
    public $nama_guru;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $agama;
    public $alamat;
    public $no_hp;
    public $npwp;
    public $pendidikan_terakhir;
    public $jurusan;
    public $status_kepegawaian;
    public $status_aktif;

    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataGuruById', 'getDataGuruId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-guru')->layout(config('crud-generator.layout'));
    }

    public function store()
    {
        $this->_validate();

        $user  = User::whereEmail($this->email)->first();
        if ($user) {
            return $this->emit('showAlertError', ['msg' => 'Email Sudah Terdaftar']);
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $this->nama_guru,
                'email' => $this->email,
                'password' => Hash::make($this->nip),
            ]);

            $team = Team::find(1);
            $team->users()->attach($user, ['role' => 'guru']);
            $user->roles()->attach('0c1afb3f-1de0-4cb4-a512-f8ef9fc8e816');
            $data = [
                'user_id'  => $user->id,
                'nip'  => $this->nip,
                'nama_guru'  => $this->nama_guru,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'tempat_lahir'  => $this->tempat_lahir,
                'tanggal_lahir'  => $this->tanggal_lahir,
                'agama'  => $this->agama,
                'alamat'  => $this->alamat,
                'no_hp'  => $this->no_hp,
                'npwp'  => $this->npwp,
                'pendidikan_terakhir'  => $this->pendidikan_terakhir,
                'jurusan'  => $this->jurusan,
                'status_kepegawaian'  => $this->status_kepegawaian,
                'status_aktif'  => $this->status_aktif
            ];

            DataGuru::create($data);
            DB::commit();

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan']);
        }
    }

    public function update()
    {
        $this->_validate();

        $user = User::where('id', '!=', $this->user_id)->where('email', $this->email)->first();
        if ($user) {
            return $this->emit('showAlertError', ['msg' => 'Email Sudah Terdaftar']);
        }

        try {
            DB::beginTransaction();
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->nama_guru,
                'email' => $this->email,
                'password' => Hash::make($this->nip),
            ]);

            $data = [
                'nip'  => $this->nip,
                'nama_guru'  => $this->nama_guru,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'tempat_lahir'  => $this->tempat_lahir,
                'tanggal_lahir'  => $this->tanggal_lahir,
                'agama'  => $this->agama,
                'alamat'  => $this->alamat,
                'no_hp'  => $this->no_hp,
                'npwp'  => $this->npwp,
                'pendidikan_terakhir'  => $this->pendidikan_terakhir,
                'jurusan'  => $this->jurusan,
                'status_kepegawaian'  => $this->status_kepegawaian,
                'status_aktif'  => $this->status_aktif
            ];

            DataGuru::find($this->data_guru_id)->update($data);
            DB::commit();

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
        }
    }

    public function delete()
    {
        $guru = DataGuru::find($this->data_guru_id);
        $user = User::find($guru->user_id);

        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
        } catch (\Throwable $th) {
            DB::rollback();
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Dihapus']);
        }
    }

    public function _validate()
    {
        $rule = [
            'nip'  => 'required',
            'nama_guru'  => 'required',
            'jenis_kelamin'  => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir'  => 'required',
            'agama'  => 'required',
            'alamat'  => 'required',
            'status_kepegawaian'  => 'required',
            'status_aktif'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataGuruById($data_guru_id)
    {
        $this->_reset();
        $row = DataGuru::find($data_guru_id);
        $this->data_guru_id = $row->id;
        $this->user_id = $row->user_id;
        $this->email = $row->user->email;
        $this->nip = $row->nip;
        $this->nama_guru = $row->nama_guru;
        $this->jenis_kelamin = $row->jenis_kelamin;
        $this->tempat_lahir = $row->tempat_lahir;
        $this->tanggal_lahir = $row->tanggal_lahir;
        $this->agama = $row->agama;
        $this->alamat = $row->alamat;
        $this->no_hp = $row->no_hp;
        $this->npwp = $row->npwp;
        $this->pendidikan_terakhir = $row->pendidikan_terakhir;
        $this->jurusan = $row->jurusan;
        $this->status_kepegawaian = $row->status_kepegawaian;
        $this->status_aktif = $row->status_aktif;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataGuruId($data_guru_id)
    {
        $row = DataGuru::find($data_guru_id);
        $this->data_guru_id = $row->id;
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
        $this->data_guru_id = null;
        $this->user_id = null;
        $this->nip = null;
        $this->email = null;
        $this->nama_guru = null;
        $this->jenis_kelamin = null;
        $this->tempat_lahir = null;
        $this->tanggal_lahir = null;
        $this->agama = null;
        $this->alamat = null;
        $this->no_hp = null;
        $this->npwp = null;
        $this->pendidikan_terakhir = null;
        $this->jurusan = null;
        $this->status_kepegawaian = null;
        $this->status_aktif = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
