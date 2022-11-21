<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>tbl data guru</span>
                        </a>
                        <div class="pull-right">
                            @if ($form_active)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i class="fas fa-times"></i> Cancel</button>
                            @else
                            @if (auth()->user()->hasTeamPermission($curteam, $route_name.':create'))
                            <button class="btn btn-primary btn-sm" wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i> Add
                                New</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if ($form_active)
            <div class="card">
                <div class="card-body">
                    <x-text-field type="number" name="nip" label="Nip" />
                    <x-text-field type="text" name="nama_guru" label="Nama Guru" />
                    <x-text-field type="text" name="email" label="Email Guru" />
                    <x-select name="jenis_kelamin" label="Jenis Kelamin">
                        <option value="">Select Jenis Kelamin</option>
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </x-select>
                    <x-text-field type="text" name="tempat_lahir" label="Tempat Lahir" />
                    <x-text-field type="date" name="tanggal_lahir" label="Tanggal Lahir" />
                    <x-select name="agama" label="Agama">
                        <option value="">Select Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Konghucu">Konghucu</option>
                    </x-select>
                    <x-text-field type="text" name="alamat" label="Alamat" />
                    <x-text-field type="text" name="no_hp" label="No Hp" />
                    <x-text-field type="text" name="npwp" label="Npwp" />
                    <x-text-field type="text" name="pendidikan_terakhir" label="Pendidikan Terakhir" />
                    <x-text-field type="text" name="jurusan" label="Jurusan" />
                    <x-select name="status_kepegawaian" label="Status Kepegawaian">
                        <option value="">Select Status Kepegawaian</option>
                        <option value="PNS">PNS</option>
                        <option value="Honorer">Honorer</option>
                    </x-select>
                    <x-select name="status_aktif" label="Status Aktif">
                        <option value="">Select Status Aktif</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </x-select>

                    <div class="form-group">
                        <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @else
            <livewire:table.data-guru-table params="{{$route_name}}" />
            @endif

        </div>

        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')



    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                
                
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
            });

            window.livewire.on('showModalConfirm', (data) => {
                $('#confirm-modal').modal(data)
            });
        })
    </script>
    @endpush
</div>