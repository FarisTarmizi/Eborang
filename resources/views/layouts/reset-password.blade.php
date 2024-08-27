
@extends('layouts.LoginPage')
@section('title','PERALATAN ICT - MBAS')
@section('test')
    @if(Session::has('success'))
        <script>
            Swal.fire({
                title: "Pemberitahuan",
                text: "{{ Session::get('success') }}",
                icon: "success",
            }).then((result) => {
                // Attempt to close the page
                window.close();
            });
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            Swal.fire({
                title: "Pemberitahuan",
                text: "{{ Session::get('error') }}",
                icon: "error"
            }).then((result) => {
                // Attempt to close the page
                window.close();
            });
        </script>
    @endif
    <div class="container">
        <div class="brand-logo">
            <img src="{{asset('image/mbas1.png')}}" alt="">
        </div>
        <div class="brand-title">LUPA KATA LALUAN</div>
        <div>
            <form action="{{route('password_email')}}" method="post" class="inputs">
                @csrf
                <!-- id -->
                <div class="input-group mb-3">
                    <input type="text" id="staff_id" name="staff_id" class="form-control" placeholder="Id Staff"
                           value="{{ old('staff_id') }}" autofocus autocomplete="staff_id">
                    @error('staff_id')
                    <span style="color: red; font-size: 13px">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group mb-3" style="position: relative;">
                    <input id="email" type="email" name="email" class="form-control" placeholder="Email"
                           autocomplete="email" value="{{ old('email') }}">
                    @error('email')
                    <span style="color: red;font-size: 13px">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">HANTAR</button>
            </form>
            <a href="{{route('login')}}" class="a "> <- Kembali</a>
        </div>
    </div>

@endsection
