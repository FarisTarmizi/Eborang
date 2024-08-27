@php use App\Models\User_info; @endphp
@extends('layouts.main')
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
    <div class="card"  style="margin-top: 7%">
        <div class="card-header">
            <h3 class="card-title">BUTIRAN</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Pekara</th>
                        <td>Permohonan Hak Capaian</td>
                    </tr>
                    @if(!is_null($loaner->tiket))
                        <tr>
                            <th>Id Pinjaman</th>
                            <td>
                                {{$loaner->tiket}}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Kategori</th>
                        @if(!is_null($loaner->category))
                            <td>
                                {{$loaner->category}}
                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
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
                        <th>Nama Akaun/Sistem</th>
                        @if(!is_null($loaner->acct_name))
                            <td>
                                {{$loaner->acct_name}}
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
                        <th>Tujuan Permohonan</th>
                        @if(!is_null($loaner->reason))
                            <td>
                                {{$loaner->reason}}
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
                            @endphp
                            <td>
                                {{$date->format('d/m/y H:i')}}
                            </td>
                        @else
                            <td>Tiada</td>
                        @endif
                    </tr>
                    @if(!is_null($loaner->review))
                        <tr>
                            @php $mssg = explode(' : ',$loaner->review); @endphp
                            <th>
                                Ulasan {{$mssg[0]}}
                            </th>
                            <td class="text-danger">{{$mssg[1]}}</td>
                        </tr>
                    @endif

                </table>

            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{route('borrower.l_history')}}"
               class="btn btn-sm btn-secondary" style="width: 190px">
                <i class="fas fa-reply"></i>
                KEMBALI
            </a>
        </div>
    </div>
@endsection
