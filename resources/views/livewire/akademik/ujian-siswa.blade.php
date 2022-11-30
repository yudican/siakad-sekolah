<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>Ujian Siswa</span>
                        </a>
                        <div class="pull-right">
                            @if (auth()->user()->role->role_type == 'siswa')
                            <button class="btn btn-primary btn-sm" wire:click="confirmFinish">Kirim Jawaban</button>
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="mb-4">{!! $soal->nama_soal !!}</p>

                    {{-- list checkbox --}}
                    @if ($type_soal == 'pg')
                    @foreach ($soal->dataPilihanJawaban as $item)
                    <div class="d-flex justify-content-start align-items-center mb-3">
                        <input id="my-input" type="checkbox" wire:model="pilihan_jawaban.{{$item->id}}" value="{{$item->id}}" wire:click="handleAnswer({{$item->id}})">
                        <label for="my-input" class="form-check-label ml-3">{{$item->pilihan_jawaban}}</label>
                    </div>
                    @endforeach
                    @else
                    @if (auth()->user()->role->role_type == 'siswa')
                    <x-textarea name="jawaban.{{$soal_id}}" label="Input Jawaban" />
                    <button class="btn btn-primary btn-sm" wire:click="saveJawaban">Simpan Jawaban</button>
                    @else
                    <p>Jawaban: </p>
                    <p>{{getJawaban($soal_id)}}</p>
                    <x-text-field name="nilai.{{$soal_id}}" label="Input Nilai" />
                    <button class="btn btn-primary btn-sm" wire:click="saveNilai">Simpan Nilai</button>
                    @endif
                    @endif


                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="ctimercountdown">
                        {{$countDowntimer}}
                    </div>
                    <div class="row">
                        @foreach ($soals as $key => $item)
                        @if (isAnswered($item->id, $ujian_id,$type_soal))
                        <div class="col-2">
                            <button class="btn btn-warning btn-sm" wire:click="changeSoal({{$item->id}})">{{$key}}</button>
                        </div>
                        @else
                        @if ($item->id == $soal_id)
                        <div class="col-2">
                            <button class="btn btn-success btn-sm" wire:click="changeSoal({{$item->id}})">{{$key}}</button>
                        </div>
                        @else
                        <div class="col-2">
                            <button class="btn btn-danger btn-sm" wire:click="changeSoal({{$item->id}})">{{$key}}</button>
                        </div>
                        @endif

                        @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Kirim Jawaban</h5>
                    </div>
                    <div class="modal-body">
                        <p>Ujian Akan Disimpan Dan tidak dapat diubah kembali.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='submitJawaban' class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Ya, Simpan</button>
                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Batal</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    @push('scripts')
    <script src="{{asset('assets/js/plugin/summernote/summernote-bs4.min.js')}}"></script>

    @if (auth()->user()->role->role_type == 'siswa')
    <script>
        document.addEventListener('livewire:load', function(e) {
                window.addEventListener('focus', function (event) {
                    console.log('has focus');
                });

                window.addEventListener('blur', function (event) {
                    @this.call('finishUjian');
                });
            })
    </script>
    @endif
    <script>
        document.addEventListener('livewire:load', function(e) {
            var WaktuHitung = '{{$countdown}}' || 0; 
            var IsRuntimer = 0;
            var cTimer;
            function runTimer(){ 
                distance = WaktuHitung--; 
                if(distance <= 0){
                    clearInterval(cTimer);
                    $(".ctimercountdown").html("0 Detik");   
                    @this.call('finishUjian');
                }else{ 
                    var minutes = Math.floor(distance / 60);
                    var seconds = distance - minutes * 60;
                    @this.call('setTimeReamining',distance);
                    $(".ctimercountdown").html(minutes + ":" + seconds); 
                }              
            }

            function startTimer(){
                IsRuntimer = 1;
                cTimer = setInterval(runTimer,1000);  
            }

            startTimer()
            window.livewire.on('showModalConfirm', (data) => {
                $('#confirm-modal').modal(data)
            });
        })
    </script>
    @endpush
</div>