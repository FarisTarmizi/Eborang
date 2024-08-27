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
@section('page','KATEGORI')
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
        <div class="card-header">
            <h4 class="card-title font-bold text-lg">Senarai Kategori Peralatan</h4>
            <div class="table-responsive mt-3">
                <table class="table" id="example1">
                    <thead>
                    <tr>
                        <th>Bil.</th>
                        <th>Peralatan</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($list))
                        @foreach($list as $a)
                            <tr>
                                <td>{{$loop->iteration}} .</td>
                                @if(!is_null($a->name))
                                    <td class="font-weight-bold">
                                        {{$a->name}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                <td>
                                    <a href="#" class="btn btn-sm btn-danger" style="width: 100px"
                                       data-target="#delete{{$a->name}}" data-toggle="modal">
                                        BUANG
                                        <i class="fas fa-trash-alt"></i>

                                    </a>
                                    <div class="modal fade" id="delete{{$a->name}}" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-warning">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('staff.padam_c',['id'=>$a->name])}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body text-justify">
                                                        Anda pasti untuk padam data {{$a->name}}? Semua data
                                                        berkaitan turut dipadam.
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-outline-dark"
                                                                data-dismiss="modal">Batal
                                                        </button>
                                                        <input type="submit" class="btn btn-outline-dark" value="Ya">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- SELECTING GEAR -->
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header">
            <h3 class="card-title font-bold text-lg">Tambah Jenis Peralatan Baru</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{route('staff.category_p')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Peralatan</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Jenis Peralatan"
                           autofocus autocomplete="name">
                </div>

                <button type="submit" class="btn btn-primary float-right" style="width: 120px">
                    HANTAR
                    <i class="fas fa-paper-plane"></i>
                    {{--                    <i class="fas fa-plus-square"></i>--}}
                </button>
            </form>
        </div>
    </div>

@endsection
