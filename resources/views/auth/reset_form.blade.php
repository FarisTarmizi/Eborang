@extends('layouts.LoginPage')
@section('title','PERALATAN ICT - MBAS')
@section('test')
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
    <div class="container">
        <div class="brand-logo">
            <img src="{{asset('image/mbas1.png')}}" alt="">
        </div>
        <div class="brand-title">LUPA KATA LALUAN</div>
        <div>
            <form action="{{route('pass_reset')}}" method="post" class="inputs">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <!-- New Password Field -->
                <div class="form-group">
                    <label for="password">Kata laluan baharu</label>
                    <div class="input-group mb-3" style="position: relative;">
                        <input id="password" type="password" name="password" class="form-control" required autofocus
                               autocomplete="new-password">
                        <i class="far fa-eye toggle-password"
                           style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; cursor: pointer;"></i>
                        @error('updatePassword.password')
                        <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm New Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">Sahkan Kata Laluan Baharu</label>
                    <div class="input-group mb-3" style="position: relative;">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               autofocus autocomplete="new-password" class="form-control">
                        <i class="far fa-eye toggle-password"
                           style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; cursor: pointer;"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">HANTAR</button>
            </form>
            <!-- JavaScript for Toggle Password Visibility -->
            <script>
                document.querySelectorAll('.toggle-password').forEach(item => {
                    item.addEventListener('click', function () {
                        const input = this.previousElementSibling;
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        this.classList.toggle('fa-eye-slash');
                    });
                });
            </script>
        </div>
    </div>

@endsection
