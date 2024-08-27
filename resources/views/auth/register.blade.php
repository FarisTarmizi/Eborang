
@extends('layouts.LoginPage')
@section('title','DAFTAR')
@section('test')
    @if(Session::has('success'))
        <script>
            Swal.fire({
                title: "Success",
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
    <div class="container3">
        <div class="brand-logo">
            <img src="{{asset('image/mbas1.png')}}" alt="">
        </div>
        <div class="brand-title">PEMOHONAN PERALATAN ICT</div>
        <div>
            <p style="font-size: 12px;font-weight: bold">Kegunaan Kakitangan BTM Sahaja</p>
            <form action="{{ route('register') }}" method="post">
                @csrf
                <!-- id -->
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" id="id" name="id" class="form-control" placeholder="Id Staff" minlength="5"
                               maxlength="5"
                               value="{{ old('id') }}" autofocus autocomplete="id">
                    </div>
                    @error('id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <p style="color: grey;font-size: 12px">0 = KB BTM, 1 = STAFF BTM, 2 = PEMOHON, 3 = KB LAIN</p>
                    <div class="input-group ">
                        <input type="number" id="role" name="role" class="form-control" value="{{ old('role') }}"
                               autofocus autocomplete="role" placeholder="Peranan / Jawatan" min='0' max="3">
                    </div>
                    @error('role')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password -->

                

                <div class="input-group mb-3" style="position: relative;">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Kata Laluan"
                           autocomplete="current-password">
                    <i class="far fa-eye" id="togglePassword"
                       style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; cursor: pointer;"></i>
                    @error('password')
                    <span style="color: red;font-size: 13px">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3" style="position: relative;">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                           placeholder="Sahkan Kata Laluan" autocomplete="password_confirmation">
                    <i class="far fa-eye" id="togglePassword2"
                       style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; cursor: pointer;"></i>
                    @error('password_confirmation')
                    <span style="color: red;font-size: 13px">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary float-right">Register</button>
            </form>
        </div>
    </div>


    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const togglePassword2 = document.querySelector('#togglePassword2');
        const passwordInput = document.querySelector('#password');
        const passwordInput2 = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
        togglePassword2.addEventListener('click', function () {
            const type = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput2.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
