<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>tbl data soal ujians</span>
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
                    {{-- <x-select name="data_ujian_id" label="Data Ujian">
                        <option value="">Select Data Ujian</option>
                    </x-select> --}}
                    <x-text-field type="text" name="nama_soal" label="Nama Soal" />
                    <x-input-image foto="{{$gambar_soal}}" path="{{optional($gambar_soal_path)->temporaryUrl()}}" name="gambar_soal_path" label="Gambar Soal" />

                    @if ($type_soal == 'essay')
                    <div class="form-group">
                        <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                    @endif
                </div>
            </div>
            @if ($type_soal == 'pg')
            <div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pilihan Jawaban</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kunci Jawaban</th>
                                        <th>Nama Jawaban</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($pilihan_jawabans as $key => $pilihan_jawaban)
                                    <tr>
                                        <td width="15%">
                                            <div class="form-check">
                                                <input class="form-check" type="radio" wire:model="kunci_jawaban.0" id="kunci_jawaban.0" value="{{$key}}" wire:model="kunci_jawaban">
                                            </div>
                                        </td>
                                        <td>
                                            <x-text-field type="text" name="nama_jawaban.{{$key}}" />
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @else
            @livewire('table.data-soal-ujian-table', ['params' => ['route_name' => $route_name,'data_ujian_id'=>$data_ujian_id]])
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