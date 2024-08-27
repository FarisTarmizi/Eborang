@extends('layouts.brrwr')
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
@section('page','UBAH KATA LALUAN')
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
                title: "Pemberitahuan",
                text: "{{ Session::get('error') }}",
                icon: "error"
            });
        </script>
    @endif
    <div class="card w-75 mx-auto mt-5">
        <div class="card-header">
            <h3 class="card-title">UBAH KATA LALUAN</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <!-- Current Password Field -->
                <div class="form-group">
                    <label for="current_password">Kata Laluan Semasa</label>
                    <div class="input-group mb-3" style="position: relative;">
                        <input id="current_password" type="password" name="current_password" required autofocus
                               autocomplete="current-password" class="form-control">
                        <i class="far fa-eye toggle-password"
                           style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; cursor: pointer;"></i>
                        @error('updatePassword.current_password')
                        <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

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

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary float-right" style="width: 120px">
                    HANTAR
                    <i class="fas fa-paper-plane"></i>
                </button>
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
