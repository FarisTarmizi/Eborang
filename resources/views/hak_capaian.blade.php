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
@section('page','PINJAMAN PERLATAN ICT')
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
        <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
            <div class="card-header font-bold text-xl">
                <h2>PERMOHANAN HAK CAPAIAN</h2>
            </div>
            <div class="card-body">
                <div class="progress mb-6">
                    <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 0;" aria-valuenow="50"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="registration-form" method="POST" action="{{route('borrower.p_capaian')}}">
                    @csrf
                    <div class="form-step step-1">
                        <h3 class="text-center font-weight-bold mb-6">MAKLUMAT PEMOHON</h3>
                        <div class="form-group">
                            <label for="id">ID Staff</label>
                            <input type="text" id="id" name="id" class="form-control" placeholder="Staff Id"
                                   minlength="5" maxlength="5" value="{{$a->id}}" autofocus autocomplete="id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="{{$a->name}}" autofocus autocomplete="name"
                                   placeholder="Username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Telefon</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{$a->phone}}"
                                   autofocus autocomplete="phone" placeholder="No. Telefon" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{$a->email}}"
                                   autofocus autocomplete="email" placeholder="Email MBAS" readonly>
                        </div>
                        <div class="form-group">
                            <label for="department">Bahagian</label>
                            <input type="text" id="department" name="department" class="form-control"
                                   value="{{$a->department}}" autofocus autocomplete="department"
                                   placeholder="Department Full Name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label><b class="text-danger">*</b>
                            <input type="text" id="unit" name="unit" class="form-control"
                                   value="{{old('unit')}}" autofocus autocomplete="unit"
                                   placeholder="Nama Penuh Unit" required>
                        </div>
                        <div class="form-group">
                            <label for="jwtn">Jawatan</label><b class="text-danger">*</b>
                            <input type="text" id="jwtn" name="jwtn" class="form-control"
                                   value="{{old('jwtn')}}" autofocus autocomplete="jwtn"
                                   placeholder="Jawatan" required>
                        </div>
                        <button type="button" class="btn btn-primary next-step mt-3 float-right" style="width: 150px">
                            SETERUSNYA
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                    <div class="form-step step-2 d-none">
                        <h3 class="text-center font-weight-bold mb-6">BUTIRAN PERMOHONAN</h3>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Kategori</label>
                                <div class="input-group mb-3">
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="PERMOHONAN BARU">PERMOHONAN BARU</option>
                                        <option value="PERTUKARAN SISTEM/MODUL">PERTUKARAN SISTEM/MODUL</option>
                                        <option value="RESET KATA LALUAN">RESET KATA LALUAN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="acct">Nama Sistem</label>
                                <input type="text" id="acct" name="acct"
                                       class="form-control " value="{{old('acct')}}"
                                       autofocus autocomplete="acct" required>
                            </div>
                            <div class="form-group col">
                                <label for="reason">Tujuan Permohonan</label>
                                <textarea name="reason" class="form-control"
                                          id="reason" required>{{old('reason')}}</textarea>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="button" class="btn btn-secondary prev-step" style="width: 120px">
                                <i class="fas fa-reply"></i>
                                KEMBALI
                            </button>
                            <button type="submit" class="btn btn-success float-right" style="width: 120px">
                                HANTAR
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('enableLaptop').addEventListener('change', function () {
            var laptopInput = document.getElementById('laptop');
            if (this.checked) {
                laptopInput.disabled = false;
            } else {
                laptopInput.disabled = true;
                laptopInput.value = 0;
            }
        });
        document.getElementById('enabproject').addEventListener('change', function () {
            var projector = document.getElementById('projektor');
            if (this.checked) {
                projector.disabled = false;
            } else {
                projector.disabled = true;
                projector.value = 0;
            }
        });
        document.getElementById('enabop').addEventListener('change', function () {
            var optional = document.getElementById('optional');
            if (this.checked) {
                optional.disabled = false;
            } else {
                optional.disabled = true;
                optional.value = 'Tiada';
            }
        });
    </script>
@endsection


