@php use App\Models\User_info; @endphp
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">BUTIRAN</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Pekara</th>
                        <td>Permohonan Peralatan ICT</td>
                    </tr>

                    @if(!is_null($loaner->tiket))
                        <tr>
                            <th>Id Pinjaman</th>
                            <td>
                                {{$loaner->tiket}}
                            </td>
                        </tr>
                    @endif

                    @if(!is_null($loaner->pic))
                        <tr>
                            <th>Pengawai</th>
                            @php $pic = User_info::whereId($loaner->pic)->first(); @endphp
                            <td>
                                {{strtoupper($pic->name)}}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Pemohon</th>
                        @if(!is_null($loaner->name))
                            <td>
                                {{strtoupper($loaner->name)}}
                                ( {{$loaner->user_id}} )
                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Bahagian</th>
                        @if(!is_null($loaner->department))
                            <td>{{$loaner->department}}</td>
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
                                @if(!is_null($loaner->email_noti))
                                    <span style="font-size: 14px" class="badge badge-warning">
                                        Lewat kembalikan peralatan
                                    </span>
                                @endif
                            </th>
                            <td>
                                @foreach($list as $l)
                                    {{$l->tag}} - <b> {{$l->type}} </b><br>
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
                    <tr>
                        <th>Lokasi Peralatan Digunakan</th>
                        @if(!is_null($loaner->location))
                            <td>{{$loaner->location}}</td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    <tr>
                        @php $mssg = explode(' : ',$loaner->gear_mssg); @endphp
                        <th>Ulasan {{$mssg[0]}}</th>
                        <td class="text-danger">{{$mssg[1]}}</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{route('staff.application')}}"
               class="btn btn-sm btn-secondary" style="width: 190px">
                <i class="fas fa-reply"></i>
                KEMBALI
            </a>
        </div>
    </div>
@endsection
