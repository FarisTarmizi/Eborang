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
@section('page','E-BORANG')
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
    <div style="margin-top: 10% bg-white" >
        <div class="card bg-white shadow-md rounded-lg overflow-hidden p-8 font-semibold mb-4">
            <div class="card-header">
                <h3 class="card-title text-xl font-bold mt-4">E - BORANG </h3>
            </div>
            <div class="card-body">
    <form action="{{route('borrower.e_borang_p')}}" method="post" onsubmit="return validateForm()">
        @csrf
        <!-- id -->
        <div class="input-group mb-3">
            <select name="modul" id="modul" class="form-control" required>
                <option value="">-- SILA PILIH MODUL --</option>
                <option value="PINJAMAN PERALATAN ICT">PINJAMAN PERALATAN ICT</option>
                <option value="HAK CAPAIAN">HAK CAPAIAN</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block">PILIH</button>
    </form>
</div>

<script>
    function validateForm() {
        var modul = document.getElementById("modul").value;
        if (modul === "") {
            alert("Sila pilih modul sebelum meneruskan.");
            return false;
        }
        return true;
    }
</script>
        </div>

    </div>
@endsection
