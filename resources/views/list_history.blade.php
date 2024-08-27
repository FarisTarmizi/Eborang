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
        <h1 class="text-secondary text-center" style="margin-top: 10%">TIADA REKOD PERMOHONAN</h1>
    @else
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <div style="margin-top: 10% bg-white">
            <!-- TABLE: HISTORY -->


            <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">


                <div class="card-header">
                    <h3 class="card-title text-xl font-bold">REKOD PINJAMAN PERALATAN ICT</h3>
                    <a href="{{route('borrower.borrower_home')}}"
                       class="btn btn-sm btn-primary float-right"
                       style="width: 90px">
                        MOHON
                        <i class="fas fa-folder-plus"></i>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-center" id="example1">
                            <thead>
                                <tr>
                                    <th>Bil.</th>
                                    <th>Modul</th>
                                    <th>Tarikh Mohon</th>
                                    <th>Tujuan</th>
                                    <th>Tindakan</th>
                                    <th>Hapus</th> <!-- New column for Delete button -->
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach($loaner as $name => $items)
                                @foreach($items as $a)
                                    <tr>
                                        <td>{{ $counter++ }}.</td>
                                        @if($name === 'gear' || $name === 'history_gear')
                                            @if($name === 'history_gear')
                                                @if($a->status === 'D')
                                                    <td>Pinjaman Peralatan ICT - <b class="text-success">Selesai</b></td>
                                                @else
                                                    <td>Pinjaman Peralatan ICT - <b class="text-danger">Ditolak</b></td>
                                                @endif
                                            @else
                                                <td>Pinjaman Peralatan ICT</td>
                                            @endif
                                        @elseif($name === 'hak' || $name === 'history_hak')
                                            @if($name === 'history_hak')
                                                @if($a->status === 'D')
                                                    <td>Hak Capaian - <b class="text-success">Selesai</b></td>
                                                @else
                                                    <td>Hak Capaian - <b class="text-danger">Ditolak</b></td>
                                                @endif
                                            @else
                                                <td>Hak Capaian</td>
                                            @endif
                                        @endif
                                        @if(!is_null($a->created_at))
                                            @php
                                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $a->created_at);
                                            @endphp
                                            <td>{{ $date->format('d-m-Y') }}</td>
                                        @else
                                            <td>Tiada</td>
                                        @endif
                                        @if(!is_null($a->motive))
                                            <td>{{ $a->motive }}</td>
                                        @elseif(!is_null($a->reason))
                                            <td>{{ $a->reason }}</td>
                                        @else
                                            <td>Tiada</td>
                                        @endif
                                        <td>
                                            @if($name === 'gear' || $name === 'history_gear')
                                                @if(in_array($a->status, ['P', 'M', 'R', 'B']))
                                                    <a href="{{ route('borrower.status') }}" class="btn btn-sm btn-info" style="width: 108px">
                                                        STATUS <i class="fas fa-business-time"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('borrower.d_history', ['id' => $a->id, 'modul' => 'gear']) }}" class="btn btn-sm btn-info" style="width: 108px">
                                                        BUTIRAN <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            @else
                                                @if(in_array($a->status, ['P', 'M', 'R']))
                                                    <a href="{{ route('borrower.status2') }}" class="btn btn-sm btn-info" style="width: 108px">
                                                        STATUS <i class="fas fa-business-time"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('borrower.d_history', ['id' => $a->id, 'modul' => 'hak']) }}" class="btn btn-sm btn-info" style="width: 108px">
                                                        BUTIRAN <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Delete Button -->
                                            <!-- Trigger Button -->
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $a->id }}" style="width: 108px">
                HAPUS <i class="fas fa-trash"></i>
            </button>

                        <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $a->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                             <div class="modal-content bg-white">
                            <form action="{{ route('borrower.delete_history', ['id' => $a->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $a->id }}">Pengesahan Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                Adakah anda pasti untuk memadam sejarah ini?
                            </div>
                            <div class="modal-footer justify-content-between">
                                     <button type="button" class="btn btn-outline-dark" data-dismiss="modal">BATAL</button>
                                    <button type="submit" class="btn btn-danger">HAPUS</button>
                            </div>
                                    </form>
                                </div>
                         </div>
                    </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
    </div>
    @endif
@endsection
