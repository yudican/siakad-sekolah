<?php

namespace App\Http\Livewire\Akademik;

use App\Models\DataSiswa;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class DataSiswaController extends Component
{

    public $data_siswa_id;
    public $user_id;
    public $nis;
    public $nama_siswa;
    public $email;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $agama;
    public $alamat;
    public $no_hp;
    public $nama_ayah;
    public $nama_ibu;
    public $pekerjaan_ayah;
    public $pekerjaan_ibu;
    public $no_hp_ortu;
    public $alamat_ortu;
    public $nama_wali;
    public $pekerjaan_wali;
    public $no_hp_wali;
    public $alamat_wali;
    public $asal_sekolah;
    public $tahun_lulus;
    public $alamat_asal_sekolah;
    public $no_ijazah;
    public $no_skhun;
    public $no_un;
    public $no_seri_ijazah;
    public $no_seri_skhun;



    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataSiswaById', 'getDataSiswaId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.akademik.data-siswa')->layout(config('crud-generator.layout'));
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
                'name' => $this->nama_siswa,
                'email' => $this->email,
                'password' => Hash::make($this->nis),
            ]);

            $team = Team::find(1);
            $team->users()->attach($user, ['role' => 'siswa']);
            $user->roles()->attach('90598899-416f-4de0-947f-c77ac2ca4eb2');
            $data = [
                'user_id'  => $user->id,
                'nis'  => $this->nis,
                'nama_siswa'  => $this->nama_siswa,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'tempat_lahir'  => '-',
                'agama'  => '-',
                'alamat'  => '-',
                'no_hp'  => '-',
                'nama_ayah'  => '-',
                'nama_ibu'  => '-',
                'pekerjaan_ayah'  => '-',
                'pekerjaan_ibu'  => '-',
                'no_hp_ortu'  => '-',
                'alamat_ortu'  => '-',
                'nama_wali'  => '-',
                'pekerjaan_wali'  => '-',
                'no_hp_wali'  => '-',
                'alamat_wali'  => '-',
                'asal_sekolah'  => '-',
                'tahun_lulus'  => '-',
                'alamat_asal_sekolah'  => '-',
                'no_ijazah'  => '-',
                'no_skhun'  => '-',
                'no_un'  => '-',
                'no_seri_ijazah'  => '-',
                'no_seri_skhun'  => '-'
            ];

            DataSiswa::create($data);
            DB::commit();
            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->_reset();
            dd($th->getMessage());
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
                'name' => $this->nama_siswa,
                'email' => $this->email,
            ]);

            $data = [
                'nis'  => $this->nis,
                'nama_siswa'  => $this->nama_siswa,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'tempat_lahir'  => '-',
                'agama'  => '-',
                'alamat'  => '-',
                'no_hp'  => '-',
                'nama_ayah'  => '-',
                'nama_ibu'  => '-',
                'pekerjaan_ayah'  => '-',
                'pekerjaan_ibu'  => '-',
                'no_hp_ortu'  => '-',
                'alamat_ortu'  => '-',
                'nama_wali'  => '-',
                'pekerjaan_wali'  => '-',
                'no_hp_wali'  => '-',
                'alamat_wali'  => '-',
                'asal_sekolah'  => '-',
                'tahun_lulus'  => '-',
                'alamat_asal_sekolah'  => '-',
                'no_ijazah'  => '-',
                'no_skhun'  => '-',
                'no_un'  => '-',
                'no_seri_ijazah'  => '-',
                'no_seri_skhun'  => '-'
            ];
            $row = DataSiswa::find($this->data_siswa_id);

            $row->update($data);
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
        $siswa = DataSiswa::find($this->data_siswa_id);
        $user = User::find($siswa->user_id);

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
            'email'  => 'required',
            'nis'  => 'required',
            'nama_siswa'  => 'required',
            'jenis_kelamin'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataSiswaById($data_siswa_id)
    {
        $this->_reset();
        $row = DataSiswa::find($data_siswa_id);
        $this->data_siswa_id = $row->id;
        $this->user_id = $row->user_id;
        $this->email = $row->user->email;
        $this->nis = $row->nis;
        $this->nama_siswa = $row->nama_siswa;
        $this->jenis_kelamin = $row->jenis_kelamin;
        $this->tempat_lahir = $row->tempat_lahir;
        $this->tanggal_lahir = $row->tanggal_lahir;
        $this->agama = $row->agama;
        $this->alamat = $row->alamat;
        $this->no_hp = $row->no_hp;
        $this->nama_ayah = $row->nama_ayah;
        $this->nama_ibu = $row->nama_ibu;
        $this->pekerjaan_ayah = $row->pekerjaan_ayah;
        $this->pekerjaan_ibu = $row->pekerjaan_ibu;
        $this->no_hp_ortu = $row->no_hp_ortu;
        $this->alamat_ortu = $row->alamat_ortu;
        $this->nama_wali = $row->nama_wali;
        $this->pekerjaan_wali = $row->pekerjaan_wali;
        $this->no_hp_wali = $row->no_hp_wali;
        $this->alamat_wali = $row->alamat_wali;
        $this->asal_sekolah = $row->asal_sekolah;
        $this->tahun_lulus = $row->tahun_lulus;
        $this->alamat_asal_sekolah = $row->alamat_asal_sekolah;
        $this->no_ijazah = $row->no_ijazah;
        $this->no_skhun = $row->no_skhun;
        $this->no_un = $row->no_un;
        $this->no_seri_ijazah = $row->no_seri_ijazah;
        $this->no_seri_skhun = $row->no_seri_skhun;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataSiswaId($data_siswa_id)
    {
        $row = DataSiswa::find($data_siswa_id);
        $this->data_siswa_id = $row->id;
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
        $this->data_siswa_id = null;
        $this->user_id = null;
        $this->nis = null;
        $this->email = null;
        $this->nama_siswa = null;
        $this->jenis_kelamin = null;
        $this->tempat_lahir = null;
        $this->tanggal_lahir = null;
        $this->agama = null;
        $this->alamat = null;
        $this->no_hp = null;
        $this->nama_ayah = null;
        $this->nama_ibu = null;
        $this->pekerjaan_ayah = null;
        $this->pekerjaan_ibu = null;
        $this->no_hp_ortu = null;
        $this->alamat_ortu = null;
        $this->nama_wali = null;
        $this->pekerjaan_wali = null;
        $this->no_hp_wali = null;
        $this->alamat_wali = null;
        $this->asal_sekolah = null;
        $this->tahun_lulus = null;
        $this->alamat_asal_sekolah = null;
        $this->no_ijazah = null;
        $this->no_skhun = null;
        $this->no_un = null;
        $this->no_seri_ijazah = null;
        $this->no_seri_skhun = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
