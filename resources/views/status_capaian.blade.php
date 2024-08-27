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
            $current = new DateTime();
            $crt = DateTime::createFromFormat('Y-m-d H:i:s', $brg->created_at);
        @endphp

        {{--   Notification     --}}
        @if($brg->status === 'X')
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Permohonan anda ditolak atau kiv",
                    icon: "error",
                });
            </script>
        @endif
        @if($brg->status === 'D')
            <script>
                Swal.fire({
                    title: "Pemberitahuan",
                    text: "Permohonan hak capaian telah selesai diproses",
                    icon: "success",
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
                <li class="step-wizard-item  @if($brg->status ==='R') current-item @endif">
                    <span class="progress-count">3</span>
                    <span class="progress-label">Permohonan <br> Sedang Diuruskan</span>
                </li>
                <li class="step-wizard-item @if($brg->status==='D') current-item @endif">
                    <span class="progress-count">5</span>
                    <span class="progress-label">Selesai</span>
                </li>
            </ul>
        @endif

        {{--   Content     --}}
        <div class="card">
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
                                    PERMOHONAN HAK CAPAIAN
                                @else
                                    {{$brg->tiket}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{$brg->category}}</td>
                        </tr>
                        <tr>
                            <th>Id Pemohon</th>
                            <td>{{$brg->user_id}}</td>
                        </tr>
                        <tr>
                            <th>Nama Akaun/Sistem</th>
                            <td>{{$brg->acct_name}}</td>
                        </tr>
                        <tr>
                            <th>Tujuan Permohonan</th>
                            <td>{{$brg->reason}}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Mohon</th>
                            <td>{{($crt->format('d-m-Y'))}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            {{--  P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= DONE, X = REJECTED --}}
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
                                <td class="text-info">STAFF BTM : permohonan sedang diuruskan</td>
                            @elseif($brg->status === 'X')
                                @php $mssg = explode(' : ',$brg->review); @endphp
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
                                                <form action="{{route('borrower.remove2',['id'=>$brg->id])}}"
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
                                        <b> Permohonan telah berjaya dilaksanakan</b>
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
                                                <form action="{{route('borrower.remove2',['id'=>$brg->id])}}"
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
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection


