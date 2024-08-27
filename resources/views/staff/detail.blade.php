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
    <!-- TABLE: LOANER -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header font-bold text-xl border-white">BUTIRAN</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Pekara</th>
                        <td>Permohonan Peralatan ICT</td>
                    </tr>
                    @if($loaner->status !== 'P' && $loaner->status !== 'M')
                        <tr>
                            <th>Id Pemohonan</th>
                            <td>
                                {{$loaner->tiket}}
                            </td>
                        </tr>
                    @endif
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
                        <th>Bilangan Peralatan</th>
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
                    @if(!is_null($loaner->gear_id))
                        <tr>
                            <th>
                                Senarai Peralatan
                                @if(!is_null($loaner->gear_mssg))
                                    <p style="font-size: 14px" class="text-info">
                                        Pesanan: {{$loaner->gear_mssg}}
                                    </p>

                                @endif
                            </th>
                            <td>
                                @foreach($list as $l)
                                    {{$l->tag}} - {{$l->no_siri}}<b> ( {{$l->type}} )</b><br>
                                @endforeach
                            </td>
                        </tr>
                    @endif
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
                        <th>Tarikh Mohon</th>
                        @if(!is_null($loaner->created_at))
                            @php
                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $loaner->created_at);
                                $start = DateTime::createFromFormat('Y-m-d', $loaner->start);
                                $end = DateTime::createFromFormat('Y-m-d', $loaner->end);
                            @endphp
                            <td>
                                {{$date->format('d-m-Y H:i:s')}}
                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    <tr>
                        <th>
                            Tarikh Pengunaan <br>
                            @if(!(is_null($loaner->start)&&is_null($loaner->end)) && $loaner->status ==='B')
                                @php
                                    $start = DateTime::createFromFormat('Y-m-d', $loaner->start);
                                    $end = DateTime::createFromFormat('Y-m-d', $loaner->end);
                                    $current = new DateTime();
                                @endphp
                                @if(!($current>$end))
                                    <span class="badge badge-warning animation__shake">
                                                         Tamat {{$current->diff($end)->d + 1 . ' hari lagi'}}
                                                        </span>
                                @else
                                    <span class="badge badge-danger">
                                                          Lebih Masa {{$current->diff($end)->d.' Hari'}} !
                                                        </span>
                                @endif
                            @endif
                        </th>
                        @if(!(is_null($loaner->start)&&is_null($loaner->end)))
                            <td>
                                <b> {{$start->format('d-m-Y')}} </b>
                                <br>
                                hingga
                                <br>
                                <b> {{$end->format('d-m-Y')}} </b>
                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Lokasi Peralatan Digunakan</th>
                        @if(!is_null($loaner->location))
                            <td>{{$loaner->location}}</td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Pengawai Bertanggungjawab</th>
                        @if(!is_null($loaner->pic))
                            <td>
                                {{$loaner->in_charge->name}} -
                                <b>{{$loaner->pic}}</b>

                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                </table>

            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{route('staff.application')}}" class="btn btn-sm btn-secondary prev-step"
               style="width: 230px">
                <i class="fas fa-reply"></i>
                KEMBALI
            </a>
            @if($loaner->status === 'R')
                @if(is_null($loaner->gear_id))
                    <a href="{{route('staff.set_gear',['id'=>$loaner->id])}}" class="btn btn-sm btn-success"
                       style="width: 210px">
                        URUS PERALATAN
                        <i class="fas fa-tools"></i>
                    </a>
                @else
                    <a href="#" class="btn btn-sm btn-success"
                       style="width: 270px" data-target="#borrow" data-toggle="modal">
                        PERALATAN TELAH DIAMBIL
                        <i class="fas fa-wrench"></i>
                    </a>
                    {{--give modal--}}
                    <div class="modal fade" id="borrow" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content bg-warning">
                                <div class="modal-header">
                                    <h4 class="modal-title">PENGESAHAN</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('staff.pinjam',['id'=>$loaner->id])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        Anda pasti pemohon telah mengambil peralatan?
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Batal
                                        </button>
                                        <input type="submit" class="btn btn-outline-dark" value="Ya">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <a href="#" class="btn btn-sm btn-success"
                   style="width: 270px" data-target="#returned" data-toggle="modal">
                    PERALATAN TELAH DIPULANGKAN
                    <i class="fas fa-wrench"></i>
                </a>
                {{--returned modal--}}
                <div class="modal fade" id="returned" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content bg-warning">
                            <div class="modal-header">
                                <h4 class="modal-title">PENGESAHAN</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('staff.pulangan',['id'=>$loaner->id])}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    Anda pasti semua peralatan ada?
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Batal
                                    </button>
                                    <input type="submit" class="btn btn-outline-dark" value="Ya">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
