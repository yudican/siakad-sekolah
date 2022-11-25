<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>tbl data jadwal pelajaran</span>
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
                    <x-select name="akademik_id" label="Akademik">
                        <option value="">Select Akademik</option>
                        @foreach ($akademiks as $akademik)
                        <option value="{{$akademik->id}}">{{$akademik->nama_akademik}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="kelas_id" label="Kelas" multiple ignore>
                        <option value="">Select Kelas</option>
                        @foreach ($kelass as $kelas)
                        <option value="{{$kelas->id}}">{{$kelas->nama_kelas}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="mapel_id" label="Mata Pelajaran">
                        <option value="">Select Mata Pelajaran</option>
                        @foreach ($mapels as $mapel)
                        <option value="{{$mapel->id}}">{{$mapel->nama_mapel}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="guru_id" label="Guru Pengampu">
                        <option value="">Select Guru Pengampu</option>
                        @foreach ($gurus as $guru)
                        <option value="{{$guru->id}}">{{$guru->nama_guru}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="jurusan_id" label="Jurusan">
                        <option value="">Select Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                        <option value="{{$jurusan->id}}">{{$jurusan->nama_jurusan}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="hari" label="Hari">
                        <option value="">Select Hari</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jumat</option>
                        <option value="6">Sabtu</option>
                    </x-select>
                    <x-text-field type="time" name="jam_mulai" label="Jam Mulai" />
                    <x-text-field type="time" name="jam_selesai" label="Jam Selesai" />

                    <div class="form-group">
                        <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @else
            <livewire:table.data-jadwal-pelajaran-table params="{{$route_name}}" />
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
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                $('#kelas_id').select2({
                    theme: "bootstrap",
                });
                $('#kelas_id').on('change', function (e) {
                    let data = $(this).val();
                    @this.set('kelas_id', data);
                });
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