<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>tbl data siswas</span>
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
                    <x-text-field type="text" name="nis" label="Nis" />
                    <x-text-field type="text" name="nama_siswa" label="Nama Siswa" />
                    <x-text-field type="text" name="email" label="Email Siswa" />
                    <x-select name="jenis_kelamin" label="Jenis Kelamin">
                        <option value="">Select Jenis Kelamin</option>
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </x-select>
                    {{--
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
                    <x-text-field type="text" name="nama_ayah" label="Nama Ayah" />
                    <x-text-field type="text" name="nama_ibu" label="Nama Ibu" />
                    <x-text-field type="text" name="pekerjaan_ayah" label="Pekerjaan Ayah" />
                    <x-text-field type="text" name="pekerjaan_ibu" label="Pekerjaan Ibu" />
                    <x-text-field type="text" name="no_hp_ortu" label="No Hp Ortu" />
                    <x-text-field type="text" name="alamat_ortu" label="Alamat Ortu" />
                    <x-text-field type="text" name="nama_wali" label="Nama Wali" />
                    <x-text-field type="text" name="pekerjaan_wali" label="Pekerjaan Wali" />
                    <x-text-field type="text" name="no_hp_wali" label="No Hp Wali" />
                    <x-text-field type="text" name="alamat_wali" label="Alamat Wali" />
                    <x-text-field type="text" name="asal_sekolah" label="Asal Sekolah" />
                    <x-text-field type="text" name="tahun_lulus" label="Tahun Lulus" />
                    <x-text-field type="text" name="alamat_asal_sekolah" label="Alamat Asal Sekolah" />
                    <x-text-field type="text" name="no_ijazah" label="No Ijazah" />
                    <x-text-field type="text" name="no_skhun" label="No Skhun" />
                    <x-text-field type="text" name="no_un" label="No Un" />
                    <x-text-field type="text" name="no_seri_ijazah" label="No Seri Ijazah" />
                    <x-text-field type="text" name="no_seri_skhun" label="No Seri Skhun" /> --}}

                    <div class="form-group">
                        <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @else
            <livewire:table.data-siswa-table params="{{$route_name}}" />
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