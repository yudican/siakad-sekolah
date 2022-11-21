<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>tbl data tugas</span>
                        </a>
                        <div class="pull-right">
                            @if ($form_active)
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i class="fas fa-times"></i> Cancel</button>
                                @if (auth()->user()->role->role_type == 'siswa')
                                <button class="btn btn-primary btn-sm ml-2" wire:click="showModalUpload"><i class="fas fa-upload"></i> Upload Tugas</button>
                                @endif
                            </div>
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
            @if ($tab == 'detail')
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nama Tugas</span>
                            <span>{{$row->nama_tugas}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Materi</span>
                            <span>{{$row->materi->nama_materi}}</span>
                        </li>
                        @if ($row->file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>File</span>
                            <span>{{asset('storage/'.$row->file)}}</span>
                        </li>
                        @endif
                        @if ($row->link)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Link</span>
                            <span>{{$row->link}}</span>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Kelas</span>
                            <span>{{$row->kelas->nama_kelas}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Batas Waktu</span>
                            @if ($tugas->status == 1)
                            <span>-</span>
                            @else
                            <span>{{$row->due_date}}</span>
                            @endif
                        </li>
                        @if ($tugas->status == 1)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Tanggal Pengumpulan</span>
                            <span>{{$tugas->tanggal_kirim}}</span>
                        </li>
                        @endif
                        @if ($tugas->status == 1)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nilai</span>
                            <span>{{$tugas->nilai}}</span>
                        </li>
                        @endif
                        <li class="list-group-item border-b-0">
                            <span>Deskripsi</span>
                        </li>
                        <li class="list-group-item border-t-0">
                            <span>{!! $row->deskripsi_tugas !!}</span>
                        </li>
                    </ul>
                </div>
            </div>
            @elseif ($tab == 'pengumpulan')
            <div class="card">
                @if ($tabDetail == 'detail')
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nama Siswa</span>
                            <span>{{$tugas->siswa->nama_siswa}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nama Tugas</span>
                            <span>{{$tugas->tugas->nama_tugas}}</span>
                        </li>
                        @if ($tugas->file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>File</span>
                            <a href="{{asset('storage/'.$tugas->file)}}" target="_blank" rel="noopener noreferrer">Lihat File</a>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Tanggal Kirim</span>
                            <span>{{$tugas->tanggal_kirim ?? '-'}}</span>
                        </li>
                        <li class="list-group-item border-b-0">
                            <span>Catatan</span>
                        </li>
                        @if ($tugas->catatan)
                        <li class="list-group-item border-t-0">
                            <span>{!! $tugas->catatan !!}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nilai</span>
                            @if ($tugas->status == 1)
                            <span>{{$tugas->nilai}}</span>
                            @else
                            <x-text-field type="text" name="nilai" label="" />
                            @endif

                        </li>
                    </ul>
                    @if ($tugas->status == 2)
                    <button class="btn btn-primary pull-right" wire:click="simpanNilai">Simpan</button>
                    @endif
                </div>
                @else
                <div class="card-body">
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Siswa</th>
                                <th>Tanggal Kirim</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumpulanTugas as $key => $item)
                            <tr key='{{$item->id}}'>
                                <th>{{$key + 1}}</th>
                                <th>{{$item->siswa->nama_siswa}}</th>
                                <th>{{$item->tanggal_kirim ?? '-'}}</th>
                                <th>{{statusPengumpulan($item->status)}}</th>
                                <th><button class="btn btn-primary btn-sm" wire:click="detailPengumpulan({{$item->id}})">Detail</button></th>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endif
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <x-text-field type="text" name="nama_tugas" label="Nama Tugas" />
                    <x-text-field type="date" name="due_date" label="Due Date" />
                    <x-select name="kelas_id" label="Kelas">
                        <option value="">Select Kelas</option>
                        @foreach ($kelass as $item)
                        <option value="{{$item->id}}">{{$item->nama_kelas}}</option>
                        @endforeach
                    </x-select>
                    <x-select name="materi_id" label="Materi">
                        <option value="">Select Materi</option>
                        @foreach ($materis as $item)
                        <option value="{{$item->id}}">{{$item->nama_materi}}</option>
                        @endforeach
                    </x-select>
                    <x-input-file file="{{$file}}" path="{{optional($file_path)->getClientOriginalName()}}" name="file_path" label="File" />
                    <div wire:ignore class="form-group @error('deskripsi_tugas')has-error has-feedback @enderror">
                        <label for="deskripsi_tugas" class="text-capitalize">Deskripsi Tugas</label>
                        <textarea wire:model="deskripsi_tugas" id="deskripsi_tugas" class="form-control"></textarea>
                        @error('deskripsi_tugas')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary pull-right" wire:click="{{$update_mode ? 'update' : 'store'}}">Simpan</button>
                    </div>
                </div>
            </div>
            @endif
            @else
            <livewire:table.data-tugas-table params="{{$route_name}}" />
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

        <div id="upload-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Upload Jawaban Tugas</h5>
                    </div>
                    <div class="modal-body">
                        <x-input-file file="{{$file}}" path="{{optional($file_path)->getClientOriginalName()}}" name="file_path" label="File" />
                        <div wire:ignore class="form-group @error('catatan')has-error has-feedback @enderror">
                            <label for="catatan" class="text-capitalize">Catatan</label>
                            <textarea wire:model="catatan" id="catatan" class="form-control"></textarea>
                            @error('catatan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='uploadJawaban' class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Upload</button>
                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{asset('assets/js/plugin/summernote/summernote-bs4.min.js')}}"></script>


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('loadForm', (data) => {
                $('#deskripsi_tugas').summernote({
                    placeholder: 'deskripsi_tugas',
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                    tabsize: 2,
                    height: 300,
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('deskripsi_tugas', contents);
                        }
                    }
                });
            });

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
            });
            window.livewire.on('showModalConfirm', (data) => {
                $('#confirm-modal').modal('show')
            });
            window.livewire.on('showModalUpload', (data) => {
                if (data == 'show') {
                    $('#catatan').summernote({
                        placeholder: 'catatan',
                        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                        tabsize: 2,
                        height: 300,
                        callbacks: {
                            onChange: function(contents, $editable) {
                                @this.set('catatan', contents);
                            }
                        }
                    });
                }
                $('#upload-modal').modal(data)
            });
        })
    </script>
    @endpush
</div>