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
@section('page','UTAMA')
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
                title: "Pemberitahuan",
                text: "{{ Session::get('error') }}",
                icon: "error"
            });
        </script>
    @endif
    @if(empty($loaner))
    <h1 class="text-secondary bg-white flex items-center justify-center h-3/4">TIADA PERMOHONAN</h1>
    @else
        <!-- TABLE: LOANER -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">REKOD PINJAMAN PERALATAN ICT</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center" id="example1">
                        <thead>
                        <tr>
                            <th>Bil.</th>
                            <th>Tarikh Mohon</th>
                            <th>Tujuan</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loaner as $a)
                            <tr>
                                <td>{{$loop->iteration}} .</td>
                                @if(!is_null($a->application->name))
                                    <td class="font-weight-bold">
                                        {{strtoupper($a->application->name)}}
                                        ( {{$a->user_id}} )
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($a->created_at))
                                    @php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $a->created_at);
                                        $start = DateTime::createFromFormat('Y-m-d', $a->start);
                                        $end = DateTime::createFromFormat('Y-m-d', $a->end);
                                    @endphp
                                    <td>
                                        {{$date->format('d-m-Y')}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($a->motive))
                                    <td>
                                        {{$a->motive}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                <td>
                                    @if($a->status==='P' || $a->status==='M' ||$a->status==='R' ||$a->status==='B'||$a->status==='D')
                                        @if($a->status==='D')
                                            <a href="{{route('borrower.d_history',['id'=>$a->tiket])}}"
                                               class="btn btn-sm btn-info"
                                               style="width: 90px">
                                                BUTIRAN
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{route('borrower.d_history',['id'=>$a->tiket])}}"
                                           class="btn btn-sm btn-info"
                                           style="width: 90px">
                                            BUTIRAN
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @else
                                        {{--  Detail Info   --}}
                                        <a href="{{route('borrower.d_history',['id'=>$a->tiket])}}"
                                           class="btn btn-sm btn-info"
                                           style="width: 90px">
                                            BUTIRAN
                                            <i class="fas fa-eye"></i>
                                        </a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@endsection
