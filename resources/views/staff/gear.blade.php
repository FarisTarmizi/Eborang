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
@section('page','TAMBAH PERALATAN ICT')
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
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
        <div class="card-header">
            <h3 class="card-title font-bold text-lg">SENARAI PERALATAN ICT</h3>
            <a href="{{route('staff.g_form')}}" class="btn btn-sm btn-success float-right"
               style="width: 208px">
                TAMBAH
                <i class="fas fa-plus-square"></i>
            </a>
            
            <a href="{{route('staff.category')}}" class="btn btn-sm btn-info float-right" style="width: 208px">
                KATEGORI PERALATAN
                <i class="fas fa-tools"></i>
            </a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="example1">
                    <thead>
                    <tr>
                        <th>Bil.</th>
                        <th>Peralatan</th>
                        <th>No. Tag BTM</th>
                        <th>Model</th>
                        <th>No. Siri</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($list))
                        @foreach($list as $a)
                            <tr>
                                <td>{{$loop->iteration}} .</td>
                                @if(!is_null($a->type))
                                    <td class="font-weight-bold">
                                        {{$a->type}}
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($a->tag))
                                    <td>
                                        {{strtoupper($a->tag)}}
                                        @if(!is_null($a->status))
                                            <span class="badge badge-danger">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                Tersedia
                                            </span>
                                        @endif
                                    </td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($a->model))
                                    <td>{{strtoupper($a->model)}}</td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                @if(!is_null($a->no_siri))
                                    <td>{{$a->no_siri}}</td>
                                @else
                                    <td>Tiada</td>
                                @endif
                                <td>
                                    <a href="#" class="btn btn-sm btn-info" style="width: 100px"
                                       data-target="#edit{{$a->id}}"
                                       data-toggle="modal">
                                        EDIT
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="modal fade" id="edit{{$a->id}}" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-info">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">EDIT DATA {{$a->tag}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('staff.edit_g',['id'=>$a->id])}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="type">Peralatan:</label>
                                                            <select name="type" class="form-control" id="type">
                                                                @foreach($type as $l)
                                                                    <option value="{{$l->name}}"
                                                                            @if($a->type == $l->type) selected @endif>
                                                                        {{$l->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="model">Model:</label>
                                                            <input type="text" name="model" class="form-control"
                                                                   id="model" placeholder="Nyatakan Model"
                                                                   value="{{$a->model}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tag">No. Tag BTM:</label>
                                                            <input type="text" name="tag" class="form-control" id="tag"
                                                                   placeholder="Nyatakan No. Tag"
                                                                   value="{{$a->tag}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="no_siri">No. Siri:</label>
                                                            <input type="text" name="no_siri" class="form-control"
                                                                   id="no_siri"
                                                                   placeholder="Nyatakan No. Siri"
                                                                   value="{{$a->no_siri}}">
                                                        </div>
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


                                    <a href="#" class="btn btn-sm btn-danger" style="width: 100px"
                                       data-target="#delete{{$a->id}}" data-toggle="modal">
                                        BUANG
                                        <i class="fas fa-trash-alt"></i>

                                    </a>
                                    <div class="modal fade" id="delete{{$a->id}}" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-warning">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">PENGESAHAN</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{route('staff.padam_g',['id'=>$a->id])}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Anda pasti untuk padam data {{$a->tag}}?
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
                    @else
                        <tr>
                            <td colspan="5">NO RECORD FOUND</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
