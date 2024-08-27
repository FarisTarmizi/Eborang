
@extends('layouts.LoginPage')
@section('title','E-BORANG | MBAS')
@section('test')
    @if(Session::has('register'))
        <script>
            Swal.fire({
                title: "Pemberitahuan",
                text: "{{ Session::get('register') }}",
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

    <style>
    .brand-logos {
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo-container {
    width: 108px;
    height: 108px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 10px; /* Add some space between the logos. Copy div if wanna add more logos*/
}

.logo-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
    </style>
    
    <div class="container">
        

<div class="brand-logos d-flex justify-content-center align-items-center">
    <div class="logo-container">
        <img src="{{asset('image/mbas.png')}}" alt="First Logo" class="img-fluid logo-image">
    </div>
</div>
        
        <div class="brand-title">E-BORANG | ICT</div>
        <div>
            <form action="{{route('login')}}" method="post" class="inputs">
                @csrf
                <!-- id -->
                <div class="input-group mb-3">
                    <input type="text" id="staff_id" name="staff_id" class="form-control" placeholder="ID Staff"
                           value="{{ old('staff_id') }}" autofocus autocomplete="staff_id">
                    @error('staff_id')
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

                <button type="submit" class="btn btn-primary btn-block">MASUK</button>
            </form>
            <a href="{{route('password_request')}}" class="a ">Lupa Kata Laluan?</a>
        </div>
    </div>


    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
