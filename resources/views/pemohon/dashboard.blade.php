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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="mt-4">
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-500 text-white text-center py-4">
                <h2 class="text-2xl font-semibold">PERMOHANAN PERALATAN ICT</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <div class="h-2 bg-gray-300 rounded-full">
                        <div id="progress-bar" class="h-2 bg-blue-500 rounded-full" style="width: 0%;"></div>
                    </div>
                </div>
                <div>
                    <b>Perhatian:</b>
                    <p class="text-justify">
                        1. Sila mohon pinjaman peralatan <b>lima (5) hari</b> sebelum tarikh dipinjam.
                        <br> 2. Permohonan akan disemak dan status kelulusan akan diberikan dalam masa <b>dua (2) hari</b>.
                        <br> 3. Adalah menjadi <b>tanggungjawab pemohon</b> untuk memastikan semua maklumat / data dipadam atau dipindahkan sepenuhnya daripada peralatan.
                    </p>
                </div>
                <form id="registration-form" method="POST" action="{{route('borrower.borrow')}}">
                    @csrf
                    <div class="form-step step-1">
                        <h5 class="text-center font-semibold">MAKLUMAT PEMOHON</h5>
                        <div class="form-group mb-4">
                            <label for="id" class="block text-gray-700">Id Staff</label>
                            <input type="text" id="id" name="id" class="form-control mt-1 block w-full p-2 border rounded-md" placeholder="Staff Id" minlength="5" maxlength="5" value="{{$a->id}}" autofocus autocomplete="id" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label for="name" class="block text-gray-700">Nama</label>
                            <input type="text" id="name" name="name" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{$a->name}}" autofocus autocomplete="name" placeholder="Username" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label for="phone" class="block text-gray-700">No. Telefon</label>
                            <input type="text" id="phone" name="phone" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{$a->phone}}" autofocus autocomplete="phone" placeholder="No. Telefon" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{$a->email}}" autofocus autocomplete="email" placeholder="Email MBAS" readonly>
                        </div>
                        <div class="form-group mb-4">
                            <label for="department" class="block text-gray-700">Bahagian</label>
                            <input type="text" id="department" name="department" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{$a->department}}" autofocus autocomplete="department" placeholder="Department Full Name" readonly>
                        </div>
                        <div class="flex">
                            <div class="form-group mb-4 w-1/3 mr-2">
                                <label class="block text-gray-700">Tarikh Pengunaan</label>
                                <input type="date" id="start" name="start" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{ old('start') }}" autofocus autocomplete="start" required>
                                <p class="text-center mt-1">hingga</p>
                                <input type="date" id="end" name="end" class="form-control mt-1 block w-full p-2 border rounded-md" value="{{ old('end') }}" autofocus autocomplete="end" required>
                            </div>
                            <div class="form-group mb-4 w-2/3">
                                <label for="reason" class="block text-gray-700">Tujuan Permohonan</label>
                                <textarea rows="5" name="reason" class="form-control mt-1 block w-full p-2 border rounded-md" id="reason" required>{{old('reason')}}</textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary next-step mt-3 float-right bg-blue-500 text-white px-4 py-2 rounded-md" style="width: 150px">
                            SETERUSNYA
                            <i class="fas fa-share ml-2"></i>
                        </button>
                    </div>
                    <div class="form-step step-2 hidden">
                        <h5 class="text-center font-semibold">PERALATAN</h5>
                        <p class="text-warning text-center mb-5" style="font-size: 14px">
                            * Tandakan pada kotak terlebih dahulu bagi memilih peralatan
                        </p>
                        <div class="flex justify-between">
                            <div class="form-group mb-4 w-1/3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="enableLaptop" class="form-check-input">
                                    <label for="enableLaptop" class="form-check-label">Bil. Laptop</label>
                                </div>
                                <input type="number" id="laptop" name="laptop" class="form-control mt-1 block w-full p-2 border rounded-md" disabled autocomplete="laptop" min='0' value="0">
                            </div>
                            <div class="form-group mb-4 w-1/3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="enabproject" class="form-check-input">
                                    <label for="enabproject" class="form-check-label">Bil. Projektor</label>
                                </div>
                                <input type="number" id="projektor" name="projektor" class="form-control mt-1 block w-full p-2 border rounded-md" disabled autocomplete="projektor" min='0' value="0">
                            </div>
                            <div class="form-group mb-4 w-1/3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" id="enabop" class="form-check-input">
                                    <label for="enabop" class="form-check-label">Lain-lain</label><span class="text-red-500"> *Jika Perlu</span>
                                </div>
                                <input type="text" id="optional" name="optional" class="form-control mt-1 block w-full p-2 border rounded-md" disabled autocomplete="optional" placeholder="Contoh: microphone - 2" value="Tiada">
                            </div>
                        </div>

                        <div class="mt-5 flex justify-between">
                            <button type="button" class="btn btn-secondary prev-step bg-gray-500 text-white px-4 py-2 rounded-md" style="width: 120px">
                                <i class="fas fa-reply mr-2"></i>
                                KEMBALI
                            </button>
                            <button type="submit" class="btn btn-success bg-green-500 text-white px-4 py-2 rounded-md" style="width: 120px">
                                HANTAR
                                <i class="fas fa-paper-plane ml-2"></i>
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


