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
@section('page','BUTIRAN')
@section('content')
    @if(Session::has('success'))
        <script>
            Swal.fire({
                title: "Pemberitahuan",
                text: "{{ Session::get('success') }}",
                icon: "success",
            });
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            Swal.fire({
                title: "Ralat",
                text: "{{ Session::get('error') }}",
                icon: "error"
            });
        </script>
    @endif
    <!-- INFO: LOANER -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <!-- /.card-header -->
        <div class="card-header font-semibold border-white">BUTIRAN PEMOHON</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Pemohon</th>
                    @if(!is_null($loaner->application->name))
                        <td>
                            {{strtoupper($loaner->application->name)}}
                            ( {{$loaner->user_id}} )
                        </td>
                    @else
                        <td>Tiada</td>
                    @endif
                </tr>
                <tr>
                    <th>Tujuan</th>
                    @if(!is_null($loaner->motive))
                        <td>
                            {{$loaner->motive}}
                        </td>
                    @else
                        <td>Tiada</td>
                    @endif
                </tr>
                <tr>
                    <th>Tarikh Pengunaan</th>
                    @if(!(is_null($loaner->start)&&is_null($loaner->end)))
                        @php
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $loaner->created_at);
                            $start = DateTime::createFromFormat('Y-m-d', $loaner->start);
                            $end = DateTime::createFromFormat('Y-m-d', $loaner->end);
                        @endphp
                        <td>
                            {{$start->format('d-m-Y')}}
                            <b> hingga </b>
                            {{$end->format('d-m-Y')}}

                        </td>
                    @else
                        <td>Tiada</td>
                    @endif
                </tr>
                <tr>
                    <th>Senarai Peralatan</th>
                    @if(!is_null($loaner->gear))
                        @php $gear = explode(', ',$loaner->gear) @endphp
                        <td>
                            @foreach($gear as $item)
                                {{$item}} <br>
                            @endforeach
                        </td>
                    @else
                        <td>Tiada</td>
                    @endif
                </tr>
            </table>

        </div>
    </div>
    <!-- SELECTING GEAR -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header font-bold text-xl">SENARAI PERALATAN TERSEDIA</h3>
        </div>
        <!-- /.card-header -->

        <form action="{{route('staff.pp',['id'=>$loaner->id])}}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                        <tr>
                            <th>Bil.</th>
                            <th>Peralatan</th>
                            <th>Model</th>
                            <th>No. Tag BTM</th>
                            <th>No. Siri</th>
                            <th>Pilih</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!is_null($list))
                            @foreach($list as $b)
                                <tr>
                                    <td>{{$loop->iteration}} .</td>
                                    @if(!is_null($b->type))
                                        <td class="font-weight-bold">
                                            {{strtoupper($b->type)}}
                                        </td>
                                    @else
                                        <td>Tiada</td>
                                    @endif
                                    @if(!is_null($b->model))
                                        <td>
                                            {{$b->model}}
                                        </td>
                                    @else
                                        <td>Tiada</td>
                                    @endif
                                    @if(!is_null($b->tag))
                                        <td>
                                            {{$b->tag}}
                                        </td>
                                    @else
                                        <td>Tiada</td>
                                    @endif
                                    @if(!is_null($b->no_siri))
                                        <td>
                                            {{$b->no_siri}}
                                        </td>
                                    @else
                                        <td>Tiada</td>
                                    @endif
                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="{{$b->id}}"
                                               style="width: 10%">
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">NO RECORD FOUND</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="card-body">
                <div class="form-group ">
                    <label for="gear_mssg">Pesanan Kepada Pemohon</label><span class="text-danger">  * Jika Perlu</span>
                    <textarea rows="2" name="gear_mssg" class="form-control"
                              id="gear_mssg">{{old('gear_mssg')}}</textarea>
                </div>

                <div class=" mt-5">
                    <button type="submit" class="btn btn-success float-right" style="width: 120px">
                        HANTAR
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    <a href="{{route('staff.detail',['id'=>$loaner->id])}}" class="btn btn-secondary prev-step"
                       style="width: 120px">
                        <i class="fas fa-reply"></i>
                        KEMBALI
                    </a>

                </div>
            </div>
        </form>
    </div>
@endsection
