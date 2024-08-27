@extends('layouts.main')
@section('title2','STAFF TEKNOLOGI MAKLUMAT')
@section('title','STAFF')
@section('position',strtoupper($a->username))
@section('img')
    @if(!empty($a->img))
        <img src="{{asset('storage/borrower_photo/'.$a->img)}}" style="width: 35px;height: 40px"
             alt="profile" class="img-circle elevation-3">
    @else
        <img src="{{asset('image/default.png')}}"
             alt="profile" width="50" height="50" class="img-circle elevation-3">
    @endif
@endsection
@section('page','TAMBAH PERALATAN ICT')
@section('content')
    
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
    <div class="card-header">
        <h3 class="card-title font-bold text-lg">TAMBAH PERALATAN ICT</h3>
            </div>
            <form action="{{route('staff.g_form_p')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="type">Peralatan</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                            <option value="{{null}}">-- Sila Pilih --</option>
                            @foreach($list as $l)
                                <option value="{{$l->name}}">{{$l->name}}</option>
                            @endforeach
                        </select>
                        @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                               id="model" placeholder="Nyatakan Model" value="{{old('model')}}">
                        @error('model')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tag">No. Tag BTM</label>
                        <input type="text" name="tag" class="form-control  @error('tag') is-invalid @enderror"
                               id="tag" placeholder="Nyatakan No. Tag" value="{{old('tag')}}">
                        @error('tag')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_siri">No. Siri</label>
                        <input type="text" name="no_siri"
                               class="form-control  @error('no_siri') is-invalid @enderror" id="no_siri"
                               placeholder="Nyatakan No. Siri" value="{{old('no_siri')}}">
                        @error('no_siri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="{{route('staff.list_g')}}" class="btn btn-secondary ">
                        <i class="fas fa-window-close"></i>
                        Batal

                    </a>
                    <button type="submit" class="btn btn-primary float-right">
                        Simpan
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
