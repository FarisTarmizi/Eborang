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
    @if(is_null($loaner))
    <h1 class="text-secondary bg-white flex items-center justify-center" style="height: 50vh;">TIADA PERMOHONAN</h1>
    @else
        <!-- TABLE: LOANER -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
            <div class="card-header border-transparent">
                <h3 class="card-title font-bold text-lg">SENARAI PERMOHONAN PERALATAN ICT</h3>
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
                            <th>Modul</th>
                            <th>Pemohon</th>
                            <th>Tarikh Mohon</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loaner as $name => $item )
                            @if(!empty($item))
                                <tr>
                                    <td>{{$loop->iteration}} .</td>
                                    @foreach($item as $a)
                                        @if($name==='Gear')
                                            <td>Pinjaman Peralatan ICT</td>
                                            @if(!is_null($a->application->name))
                                                <td class="font-weight-bold">
                                                    {{strtoupper($a->application->name)}}
                                                    ( {{$a->user_id}} )
                                                </td>
                                            @elseif(!is_null($a->application2->name))
                                                <td class="font-weight-bold">
                                                    {{strtoupper($a->application2->name)}}
                                                    ( {{$a->user_id}} )
                                                </td>
                                            @else
                                                <td>Tiada</td>
                                            @endif
                                            @if(!is_null($a->created_at))
                                                @php
                                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $a->created_at);
                                                @endphp
                                                <td>
                                                    {{$date->format('d-m-Y')}}
                                                </td>
                                            @else
                                                <td>Tiada</td>
                                            @endif
                                            <td>
                                                @if($a->status==='P')
                                                    <a href="#" class="btn btn-sm btn-success" style="width: 108px"
                                                       data-target="#sah{{$a->id}}" data-toggle="modal">
                                                        SAH
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                    {{--Confirmation Modal--}}
                                                    <div class="modal fade" id="sah{{$a->id}}" data-backdrop="static">
                                                        <div class="modal-dialog bg-white">
                                                            <div class="modal-content bg-warning">
                                                                <div class="modal-header bg-white">
                                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{route('kb_l.sah',['id'=>$a->id])}}"
                                                                      method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body bg-white">
                                                                        <div class="form-group text-blue">
                                                                            <label for="review">Ulasan Permohonan</label>
                                                                            <textarea rows="2" name="review"
                                                                                      class="form-control"
                                                                                      id="review"
                                                                                      required>{{old('review')}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between bg-white">
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
                                                    {{--  Detail Info   --}}
                                                    <a href="{{route('kb_l.view',['id'=>$a->id])}}"
                                                       class="btn btn-sm btn-info"
                                                       style="width: 108px">
                                                        BUTIRAN
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @elseif($name==='Hak')
                                            <td>Hak Capaian</td>
                                            @if(!is_null($a->application2->name))
                                                <td class="font-weight-bold">
                                                    {{strtoupper($a->application2->name)}}
                                                    ( {{$a->user_id}} )
                                                </td>
                                            @else
                                                <td>Tiada</td>
                                            @endif
                                            @if(!is_null($a->created_at))
                                                @php
                                                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $a->created_at);
                                                @endphp
                                                <td>
                                                    {{$date->format('d-m-Y')}}
                                                </td>
                                            @else
                                                <td>Tiada</td>
                                            @endif
                                            <td>
                                                @if($a->status==='P')
                                                    <a href="#" class="btn btn-sm btn-success" style="width: 120px"
                                                       data-target="#sah{{$a->id}}" data-toggle="modal">
                                                        SAH
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                    {{--Confirmation Modal--}}
                                                    <div class="modal fade" id="sah{{$a->id}}" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content bg-warning">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{route('kb_l.sah_c',['id'=>$a->id])}}"
                                                                      method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="form-group text-blue">
                                                                            <label for="review">Ulasan Permohonan</label>
                                                                            <textarea rows="2" name="review"
                                                                                      class="form-control"
                                                                                      id="review"
                                                                                      required>{{old('review')}}</textarea>
                                                                        </div>
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
                                                    {{--  Detail Info   --}}
                                                    <a href="{{route('kb_l.view2',['id'=>$a->id])}}"
                                                       class="btn btn-sm btn-info"
                                                       style="width: 120px">
                                                        BUTIRAN
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
