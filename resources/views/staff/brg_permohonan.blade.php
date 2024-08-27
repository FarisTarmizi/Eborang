@extends('layouts.main')
@section('title','STAFF')
@section('title2','STAFF TEKNOLOGI MAKLUMAT')
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
    <div class=" mt-1">
        <div class="card">
            <div class="card-header">
                <h2>PERMOHANAN PERALATAN ICT</h2>
            </div>
            <div class="card-body">
                <div class="progress mb-4">
                    <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 0;" aria-valuenow="50"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div>
                    <b>Perhatian:</b><br>
                    <p class="text-justify">1. Sila mohon pinjaman peralatan <b> lima (5) hari</b> sebelum tarikh
                        dipinjam.
                        <br> 2. Permohonan akan disemak dan status kelulusan akan diberikan dalam masa <b> dua (2)
                            hari</b>.
                        <br> 3. Adalah menjadi <b> tanggungjawab pemohon </b> untuk memastikan semua maklumat / data
                        dipadam
                        atau dipindahkan sepenuhnya daripada peralatan.</p>
                </div>
                <form id="registration-form" method="POST" action="{{route('staff.brrw')}}">
                    @csrf
                    <div class="form-step step-1">
                        <h5 class="text-center font-weight-bold">MAKLUMAT PEMOHON</h5>
                        <div class="form-group">
                            <label for="id">Id Staff</label>
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
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Tarikh Pengunaan</label>
                                <input type="date" id="start" name="start" class="form-control mb-3 mt-1"
                                       value="{{ old('start') }}"
                                       autofocus autocomplete="start" required>
                                <p class="text-center">hingga</p>
                                <input type="date" id="end" name="end" class="form-control" value="{{ old('end') }}"
                                       autofocus autocomplete="end" required>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="reason">Tujuan Permohonan</label>
                                <textarea rows="5" name="reason" class="form-control"
                                          id="reason" required>{{old('reason')}}</textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary next-step mt-3 float-right" style="width: 150px">
                            SETERUSNYA
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                    <div class="form-step step-2 d-none">
                        <h5 class="text-center font-weight-bold">PERALATAN</h5>
                        <p class="text-warning text-center mb-5" style="font-size: 14px">
                            * Tandakan pada kotak terlebih dahulu bagi memilih peralatan
                        </p>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" id="enableLaptop" class="form-check-input">
                                    <label for="enableLaptop" class="form-check-label">Bil. Laptop</label>
                                </div>
                                <input type="number" id="laptop" name="laptop" class="form-control mb-3 mt-1" disabled
                                       autocomplete="laptop" min='0' value="0">
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" id="enabproject" class="form-check-input">
                                    <label for="enabproject" class="form-check-label">Bil. Projektor</label>
                                </div>
                                <input type="number" id="projektor" name="projektor" class="form-control mb-3 mt-1"
                                       disabled
                                       autocomplete="projektor" min='0' value="0">
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" id="enabop" class="form-check-input">
                                    <label for="enabop" class="form-check-label">
                                        Lain-lain
                                    </label><span class="text-danger"> *Jika Perlu</span>
                                </div>
                                <input type="text" id="optional" name="optional" class="form-control mb-3 mt-1"
                                       disabled autocomplete="optional" placeholder="Contoh: microphone - 2"
                                       value="Tiada">
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


