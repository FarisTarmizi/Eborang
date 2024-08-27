@extends('layouts.main')
@section('title','KETUA BAHAGIAN')
@section('title2','KETUA '.$a->department)
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
    @if(Session::has('welcome'))
        <script>
            Swal.fire({
                title: "Pemberitahuan",
                text: "{{ Session::get('welcome') }}",
                icon: "success",
            });
        </script>
    @endif
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
    @if(is_null($loaner))
        <h1 class="text-secondary text-center mt-5">TIADA PERMOHONAN</h1>
    @else
        <!-- TABLE: LOANER -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
            <div class="card-header border-none">
                <h3 class="card-title">BUTIRAN PERMOHONAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Pekara</th>
                            <td>Permohonan Peralatan ICT</td>
                        </tr>
                        <tr>
                            <th>Tarikh Mohon</th>
                            @if(!is_null($loaner->created_at))
                                @php
                                    date_default_timezone_set('Asia/Kuala_Lumpur');
                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $loaner->created_at);
                                    $start = DateTime::createFromFormat('Y-m-d', $loaner->start);
                                    $end = DateTime::createFromFormat('Y-m-d', $loaner->end);
                                @endphp
                                <td>
                                    {{$date->format('d-m-Y')}}
                                </td>
                            @else
                                <td>Tiada</td>
                            @endif
                        </tr>
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
                            <th>Bahagian</th>
                            @if(!is_null($loaner->application->department))
                                <td>{{$loaner->application->department}}</td>
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
                        <tr>
                            <th>Tujuan Pengunaan</th>
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
                                <td>
                                    {{$start->format('d-m-Y')}}
                                    <b> hingga </b>
                                    {{$end->format('d-m-Y')}}
                                </td>
                            @else
                                <td>Tiada</td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center bg-white">
                <a href="{{route('kb_l.kbl_home')}}" class="btn btn-sm btn-secondary text-white" style="width: 108px">
                    <i class="fas fa-reply text-white"></i>
                    KEMBALI
                </a>
                <a href="#" class="btn btn-sm btn-success text-white" style="width: 108px"
                   data-target="#sah" data-toggle="modal">
                    SAH
                    <i class="fas fa-check-circle text-white"></i>
                </a>
                {{--Confirmation Modal--}}
                <div class="modal fade" id="sah" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content bg-warning">
                            <div class="modal-header">
                                <h4 class="modal-title">PENGESAHAN</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('kb.sah',['id'=>$loaner->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    Anda pasti bagi mengesahkan permohonan ini?
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-dark"
                                            data-dismiss="modal">BATAL
                                    </button>
                                    <input type="submit" class="btn btn-outline-dark"
                                           value="SAH">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-sm btn-danger text-white" style="width: 108px" data-target="#tolak"
                   data-toggle="modal">
                    TOLAK
                    <i class="fas fa-window-close text-white"></i>
                </a>
                {{--Confirmation Modal--}}
                <div class="modal fade" id="tolak" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content bg-warning">
                            <div class="modal-header">
                                <h4 class="modal-title">PENGESAHAN</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('kb.tolak',['id'=>$loaner->id])}}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
                                    <label for="gear_mssg">Alasan anda menolak permohonan ini</label><br>
                                    <input type="text" id="review" name="review" placeholder="Alasan"
                                           style="width: 400px" required>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-dark"
                                            data-dismiss="modal">Batal
                                    </button>
                                    <input type="submit" class="btn btn-outline-dark"
                                           value="Ya">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
