@php use App\Models\Gear;use Illuminate\Support\Facades\Mail; @endphp
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
@section('page','SENARAI PERMOHONAN')
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
    <!-- Currently Processing -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header">
            <h3 class="card-title font-bold text-lg">SENARAI PERMOHONAN PERALATAN ICT</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  text-center" id="example1">
                    <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Pemohon</th>
                        <th>Tarikh Mohon</th>
                        <th>Peralatan</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($loaner))
                        @foreach($loaner as $b)
                            <tr>
                                @if(!is_null($b->tiket))
                                    <td class="font-weight-bold">
                                        {{$b->tiket}}
                                    </td>
                                @elseif($b->status === 'M')
                                    <td class="font-weight-bold">
                                        <span class="badge badge-warning animation__shake">
                                        <i class="fas fa-exclamation"></i>
                                        </span>
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->application->name))
                                    <td class="font-weight-bold">
                                        {{strtoupper($b->application->name)}}
                                        ( {{$b->user_id}} )
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->created_at))
                                    @php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $b->created_at);
                                    @endphp
                                    <td>
                                        {{$date->format('d-m-Y')}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->gear_id))
                                    @php
                                        $list = [];
                                        $gear = explode(', ',$b->gear_id);
                                        foreach ($gear as $g){
                                            $list[]=Gear::whereId($g)->first();
                                        }
                                    @endphp


                                    <td>
                                        @foreach($list as $l)
    {{ $l->tag ?? 'Default Tag' }} -<b>  {{ $l->type ?? 'Default Type' }} </b> <br>
@endforeach
                                    </td>
                                @else
                                    @php $gear = explode(', ',$b->gear);  @endphp
                                    <td>
                                        @foreach($gear as $g)
                                            {{$g}}<br>
                                        @endforeach
                                    </td>
                                @endif
                                @if(!is_null($b->status))
                                    {{--  P = PENDING, M = NEED PIC , R = PROCESSING,B= BORROWING, D= GEAR RETURNED --}}
                                    @if($b->status === 'M')
                                        <td class="text-danger">* Perlu Tindakan</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info" style="width: 100px"
                                               data-toggle="modal" data-target="#urus">
                                                URUS
                                                <i class="fas fa-tasks"></i>
                                            </a>
                                            {{--Confirmation Modal--}}
                                            <div class="modal fade" id="urus" data-backdrop="static">
                                                <div class="modal-dialog bg-gray-300">
                                                    <div class="modal-content bg-warning">
                                                        <div class="modal-header bg-gray-300">
                                                            <h4 class="modal-title">PENGESAHAN</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{route('staff.pic',['id'=>$b->id])}}"
                                                              method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body bg-gray-300">
                                                                Anda pasti untuk menguruskan permohonan ini?
                                                            </div>
                                                            <div class="modal-footer justify-content-between bg-gray-300 ">
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

                                            <a href="#" class="btn btn-sm btn-danger" style="width: 100px"
                                               data-target="#tolak"
                                               data-toggle="modal">
                                                TOLAK
                                                <i class="fas fa-window-close"></i>
                                            </a>
                                            {{--Confirmation Modal--}}
                                            <div class="modal fade" id="tolak" data-backdrop="static">
                                                <div class="modal-dialog bg-gray-300">
                                                    <div class="modal-content bg-warning">
                                                        <div class="modal-header bg-gray-300">
                                                            <h4 class="modal-title">PENGESAHAN</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{route('staff.reject',['id'=>$b->id])}}"
                                                              method="post">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body bg-gray-300">
                                                                <label for="gear_mssg">Alasan anda menolak permohonan
                                                                    ini</label><br>
                                                                <input type="text" id="gear_mssg" name="gear_mssg"
                                                                       placeholder="Alasan"
                                                                       style="width: 400px; " required>
                                                            </div>
                                                            <div class="modal-footer justify-content-between bg-gray-300">
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
                                        </td>
                                    @elseif($b->status === 'R' || $b->status === 'B')
                                        @php
                                            $start = DateTime::createFromFormat('Y-m-d', $b->start);
                                            $end = DateTime::createFromFormat('Y-m-d', $b->end);
                                            $current = new DateTime();
                                        @endphp
                                        @if($b->pic == $a->id )
                                            @if($b->status === 'B')
                                                <td class="text-info">
                                                    Dalam fasa pinjaman <br>
                                                    @if(!($current>$end))
                                                        <span class="badge badge-warning animation__shake">
                                                         Tamat {{$current->diff($end)->d + 1 . ' hari lagi'}}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                          Lebih Masa!
                                                        </span>
                                                    @endif
                                                </td>
                                            @else
                                                @if(!is_null($b->gear_id))
                                                    <td class="text-info">
                                                        Menunggu pemohon ambil peralatan
                                                    </td>
                                                @else
                                                    <td class="text-info">
                                                        Dalam Tindakan
                                                    </td>
                                                @endif
                                            @endif
                                            <td>
                                                <a href="{{route('staff.detail',['id'=>$b->id])}}"
                                                   class="btn btn-sm btn-info" style="width: 100px">
                                                    BUTIRAN
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($b->status === 'R')
                                                    @if(!is_null($b->gear_id) )
                                                        <a href="#" class="btn btn-sm btn-success mt-1"
                                                           style="width: 230px" data-target="#borrow"
                                                           data-toggle="modal">
                                                            PERALATAN TELAH DIAMBIL
                                                            <i class="fas fa-wrench"></i>
                                                        </a>
                                                        {{--give modal--}}
                                                        <div class="modal fade" id="borrow" data-backdrop="static">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content bg-warning">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">PENGESAHAN</h4>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        action="{{route('staff.pinjam',['id'=>$b->id])}}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body ">
                                                                            Anda pasti pemohon telah mengambil
                                                                            peralatan?
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer justify-content-between">
                                                                            <button type="button"
                                                                                    class="btn btn-outline-dark"
                                                                                    data-dismiss="modal">Batal
                                                                            </button>
                                                                            <input type="submit"
                                                                                   class="btn btn-outline-dark"
                                                                                   value="Ya">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <br>
                                                        <a href="{{route('staff.set_gear',['id'=>$b->id])}}"
                                                           class="btn btn-sm btn-success mt-1"
                                                           style="width: 150px">
                                                            URUS PERALATAN
                                                            <i class="fas fa-tools"></i>
                                                        </a>
                                                    @endif
                                                @elseif($b->status === 'B')
                                                    <a href="#" class="btn btn-sm btn-success mt-1"
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
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="{{route('staff.pulangan',['id'=>$b->id])}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        Anda pasti semua peralatan ada?
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="button"
                                                                                class="btn btn-outline-dark"
                                                                                data-dismiss="modal">Batal
                                                                        </button>
                                                                        <input type="submit"
                                                                               class="btn btn-outline-dark" value="Ya">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        @else
                                            @if($b->status === 'B')
                                                <td class="text-info">
                                                    Dalam fasa pinjaman <br>
                                                    @if(!($current>$end))
                                                        <span class="badge badge-warning animation__shake">
                                                         Tamat {{$current->diff($end)->d + 1 . ' hari lagi'}}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                          Lebih Masa!
                                                        </span>

                                                    @endif
                                                </td>
                                            @else
                                                @if(!is_null($b->gear_id))
                                                    <td class="text-info">
                                                        Menunggu pemohon ambil peralatan
                                                    </td>
                                                @else
                                                    <td class="text-info">Dalam Tindakan</td>
                                                @endif
                                            @endif
                                            <td class="text-info">
                                                <i class="fas fa-user-tie"></i><br>
                                                Diuruskan oleh: <br> {{$b->in_charge->name}}
                                            </td>
                                        @endif
                                    @elseif($b->status === 'D')
                                        <td class="text-success">Selesai</td>
                                        <td class="text-info">Menunggu Pengesahan Pengembalian Oleh Pemohon</td>
                                    @endif
                                @else
                                    <td>Tiada</td>
                                    <td>Tiada</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">TIADA REKOD</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Settel / Rejected Loaner   --}}
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header">
            <h3 class="card-title font-bold text-lg">SENARAI PERMOHONAN PERALATAN ICT - SELESAI / DITOLAK</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table  text-center" id="example2">
                    <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Pemohon</th>
                        <th>Tarikh Pulangan / Tolak</th>
                        <th>Peralatan</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($history))
                        @foreach($history as $b)
                            <tr>
                                @if(!is_null($b->tiket))
                                    <td class="font-weight-bold">
                                        {{$b->tiket}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->name))
                                    <td class="font-weight-bold">
                                        {{strtoupper($b->name)}}
                                        ( {{$b->user_id}} )
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->updated_at))
                                    @php
                                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $b->updated_at);
                                    @endphp
                                    <td>
                                        {{$date->format('d-m-Y')}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($b->gear_id))
                                    @php
                                        $list = [];
                                        $gear = explode(', ',$b->gear_id);
                                        foreach ($gear as $g){
                                            $list[]=Gear::whereId($g)->first();
                                        }
                                    @endphp
                                    <td>
                                        @foreach($list as $l)
                                        {{ $l->tag ?? " " }} -<b>  {{ $l->type ?? " " }} </b> <br>
                                    @endforeach
                                    </td>
                                @else
                                    @php $gear = explode(', ',$b->gear);  @endphp
                                    <td>
                                        @foreach($gear as $g)
                                            {{$g}}<br>
                                        @endforeach
                                    </td>
                                @endif
                                @if(!is_null($b->status))
                                    @if($b->status === 'D')
                                        <td class="text-success">Selesai</td>
                                        <td>
                                            <a href="{{route('staff.resit',['id'=>$b->id])}}" class="btn btn-warning"
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                                Borang Pengesahan
                                            </a>
                                        </td>
                                    @else
                                        @php $mssg = explode(' : ',$b->gear_mssg); @endphp
                                        <td class="text-danger">
                                            <b> PERMOHONAN DITOLAK </b><br>
                                            Ulasan {{$mssg[0]}}: <br>
                                            {{$mssg[1]}}
                                        </td>
                                        <td class="text-danger">
                                            <a href="{{route('staff.detail',['id'=>$b->user_id])}}"
                                               class="btn btn-success" style="width: 180px">
                                                BUTIRAN
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    @endif
                                @else
                                    <td>Tiada</td>
                                    <td>Tiada</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">TIADA REKOD</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

