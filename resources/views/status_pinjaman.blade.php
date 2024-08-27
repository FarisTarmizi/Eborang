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
@section('page','STATUS')
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
    @if(!is_null($brg))
        {{--     Date      --}}
        @php
            $start = DateTime::createFromFormat('Y-m-d', $brg->start);
            $end = DateTime::createFromFormat('Y-m-d', $brg->end);
            $current = new DateTime();
            $crt = DateTime::createFromFormat('Y-m-d H:i:s', $brg->created_at);
            $gear = explode(', ',$brg->gear);
        @endphp

        {{--   Notification     --}}
        @if(!is_null($brg->gear_id) && $brg->status === 'R' )
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Peralatan telah sedia untuk diambil. Sila ambil tindakan",
                    icon: "info",
                });
            </script>
        @endif
        @if($brg->status === 'X')
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Permohonan anda ditolak",
                    icon: "error",
                });
            </script>
        @endif
        @if($brg->status === 'D')
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Peralatan telah berjaya dikembalikan. Sila sahkan pengembalian peralatan",
                    icon: "success",
                });
            </script>
        @endif
        @if($brg->status === 'B' && $current>$end )
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Pinjaman melebihi masa. Sila lakukan pengembalian peralatan",
                    icon: "warning",
                });
            </script>
        @endif


        {{--   Progress Bar     --}}
        @if($brg->status === 'X')
            <ul class="step-wizard-list">
                <li class="step-wizard-item @if($brg->status==='P') current-item @endif">
                    <span class="progress-count">1</span>
                    <span class="progress-label">Pengesahan<br>Permohonan</span>
                </li>
                <li class="step-wizard-item @if($brg->status==='P') current-item @endif">
                    <span class="progress-count">X</span>
                    <span class="progress-label">Permohonan<br>Ditolak</span>
                </li>
            </ul>
        @else
            <ul class="step-wizard-list">
                <li class="step-wizard-item @if($brg->status ==='P') current-item @endif">
                    <span class="progress-count">1</span>
                    <span class="progress-label">Pengesahan<br>Permohonan</span>
                </li>
                <li class="step-wizard-item @if($brg->status ==='M') current-item @endif">
                    <span class="progress-count">2</span>
                    <span class="progress-label">Menetapkan<br>PIC</span>
                </li>
                @if($brg->status === 'R' )
                    @if(!is_null($brg->gear_id))
                        <li class="step-wizard-item current-item ">
                            <span class="progress-count">3</span>
                            <span class="progress-label text-warning">Pengambilan<br>Peralatan</span>
                        </li>
                    @else
                        <li class="step-wizard-item current-item ">
                            <span class="progress-count">3</span>
                            <span class="progress-label">Pencarian<br>Peralatan</span>
                        </li>
                    @endif
                @else
                    <li class="step-wizard-item ">
                        <span class="progress-count">3</span>
                        <span class="progress-label">Pemilihan<br>Peralatan</span>
                    </li>
                @endif
                <li class="step-wizard-item @if($brg->status==='B') current-item @endif">
                    <span class="progress-count">4</span>
                    <span class="progress-label">Pinjaman<br>Peralatan</span>
                </li>
                <li class="step-wizard-item @if($brg->status==='D') current-item @endif">
                    <span class="progress-count">5</span>
                    <span class="progress-label">Pengembalian<br>Peralatan</span>
                </li>
            </ul>
        @endif

        {{--   Content     --}}
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>
                                @if(is_null($brg->tiket))
                                    Pekara
                                @else
                                    No. Tiket
                                @endif
                            </th>
                            <td>
                                @if(is_null($brg->tiket))
                                    PERMOHONAN PERALATAN ICT
                                @else
                                    {{$brg->tiket}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Id Pemohon</th>
                            <td>{{$brg->user_id}}</td>
                        </tr>
                        <tr>
                            <th>Senarai Peralatan ICT</th>
                            <td>
                                @foreach($gear as $i)
                                    {{$i}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Tujuan</th>
                            <td>{{$brg->motive}}</td>
                        </tr>
                        @if(!is_null($brg->location))
                            <tr>
                                <th>Lokasi</th>
                                <td>{{$brg->location}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Tarikh Mohon</th>
                            <td>{{($crt->format('d-m-Y'))}}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Pengunaan</th>
                            <td>
                                {{($start->format('d-m-Y'))}} hingga {{($end->format('d-m-Y'))}}
                            </td>
                        </tr>
                        @if(!is_null($brg->review))
                            <tr>
                                <th>Ulasan KB Anda</th>
                                <td>{{$brg->review}}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Status</th>
                            {{--  P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= GEAR RETURNED, X = REJECTED --}}
                            @if($brg->status === 'P')
                                @if(is_null($brg->review))
                                    <td class="text-warning">KB : Sedang Menunggu Pengesahan KB Anda</td>
                                @else
                                    <td class="text-warning">KB BTM : Sedang Menunggu Pengesahan KB BTM</td>
                                @endif
                            @elseif($brg->status === 'M')
                                <td class="text-success">
                                    KB BTM : Telah disahkan - permohonan diserahkan kepada staff btm
                                </td>
                            @elseif($brg->status === 'R')
                                @if((!is_null($brg->gear_id)))
                                    <td class="text-info">
                                        STAFF BTM : <br> Peralatan telah sedia untuk diambil.
                                        Sila hadir Bahagian Teknologi Maklumat bagi pengambilan peralatan
                                    </td>
                                @else
                                    <td class="text-info">STAFF BTM : <br> proses pencarian peralatan</td>
                                @endif
                            @elseif($brg->status === 'B')
                                <td class="text-info">Sedang fasa pinjaman peralatan ICT</td>

                            @elseif($brg->status === 'X')
                                @php $mssg = explode(' : ',$brg->gear_mssg); @endphp
                                <td class="text-danger">
                                    <b> Permohonan anda telah ditolak. <br>Ulasan {{$mssg[0]}}: <br> </b>{{$mssg[1]}}
                                    <p class="text-info">Sila tekan butang 'maklum' di bawah untuk membolehkan melakukan
                                        permohonan baru </p>
                                    <a href="#" class="btn btn-info"
                                       style="width: 150px" data-toggle="modal" data-target="#maklum">
                                        MAKLUM
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <div class="modal fade" id="maklum" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-info">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('borrower.remove',['id'=>$brg->id])}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Anda sekiranya mempunyai sebarang kemuskilan,sila hubungi
                                                        bahagian
                                                        IT.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-outline-dark"
                                                               style="width: 100px;"
                                                               value="Ya">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td>
                                    <p class="text-success">
                                        <b> Peralatan telah berjaya dikembalikan</b>
                                    </p>
                                    <p class="text-info">
                                        Sila tekan butang 'sah' di bawah bagi melakukan permohonan baru di masa akan
                                        datang
                                    </p>
                                    <a href="#" class="btn btn-success"
                                       style="width: 150px" data-toggle="modal" data-target="#lanjut">
                                        SAH
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <div class="modal fade" id="lanjut" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-success">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('borrower.remove',['id'=>$brg->id])}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Anda sekiranya mempunyai sebarang kemuskilan,sila hubungi
                                                        bahagian
                                                        IT.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-outline-dark"
                                                               style="width: 100px;"
                                                               value="Ya">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @if($brg->status === 'B')
                            <tr>
                                <th>Tarikh pulangan peralatan</th>
                                @if(!($current>$end))
                                    <td class="text-warning">
                                        {{$end->format('d-m-Y')}}
                                        <br>
                                        baki lagi
                                        <b>
                                            {{$current->diff($end)->d + 1 .' hari'}} (1 hari ditambah bagi proses
                                            pulangan)
                                        </b>
                                    </td>
                                @else
                                    @if($current->diff($end)->d === 0)
                                        <td>
                                            <div class="text-warning">
                                                {{$end->format('d-m-Y')}}
                                            </div>
                                            <span class="badge badge-danger animation__wobble"> Hari ini !!! </span>
                                        </td>
                                    @else
                                        <td>
                                            <div class="text-danger">
                                                {{$end->format('d-m-Y')}}
                                            </div>
                                            <span
                                                class="badge badge-danger animation__wobble">lebih {{$current->diff($end)->d.' hari'}}
                                        </span>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            @else
                <h1 class="text-secondary text-center mt-5">TIADA PERMOHONAN DILAKUKAN</h1>
    @endif
@endsection


