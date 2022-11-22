<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3"></i>Jawaban Siswa</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @foreach ($jawaban_essay as $key => $essay)
                    <div class="mb-2">
                        <h1 style="font-size: 20px;">{{$key+1}}. {{$essay->dataSoalUjian->nama_soal}}</h1>
                        <p><b>Jawaban:</b></p>
                        <p>{{$essay->jawaban}}</p>
                    </div>
                    @endforeach
                    @foreach ($jawaban_pg as $key => $pg)
                    <div class="mb-2">
                        <h1 style="font-size: 20px;">{{$key+1}}. {{$pg->dataSoalUjian->nama_soal}}</h1>
                        @foreach ($pg->dataSoalUjian->dataPilihanJawaban as $item)
                        <div class="d-flex justify-content-start align-items-center mb-3 mt-3">
                            @if ($pg->data_pilihan_jawaban_id == $item->id)
                            <input id="my-input" type="checkbox" value="{{$item->id}}" wire:click="handleAnswer({{$item->id}})" checked disabled>
                            <label for="my-input" class="form-check-label ml-3 {{$pg->status > 0 ? 'text-success' : 'text-danger'}}">{{$item->pilihan_jawaban}}</label>
                            @else
                            <input id="my-input" type="checkbox" value="{{$item->id}}" wire:click="handleAnswer({{$item->id}})" disabled>
                            <label for="my-input" class="form-check-label ml-3">{{$item->pilihan_jawaban}}</label>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>