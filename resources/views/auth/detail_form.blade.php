@extends('layouts.LoginPage')
@section('title','MAKLUMAT PERIBADI')
@section('test')
    <div class="container2">
        <div class="brand-logo">
            <img src="{{ asset('image/mbas1.png') }}" alt="Brand Logo">
        </div>
        <div class="brand-title" style="font-size: 30px">PEMOHONAN PERALATAN ICT</div>
        <div>
            <p style="font-size: 14px; font-weight: bold;">Kegunaan Kakitangan MBAS Sahaja</p>
            <form action="{{ route('process') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="inputs">
                    <!-- id -->
                    <div class="mb-3">
                        <input type="text" id="id" name="id" class="form-control" value="{{ $user->staff_id }}"
                               readonly style="text-align: center">
                    </div>
                    <!-- name -->
                    <div class="mb-3">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama Penuh"
                               value="{{ $dep->leader ?? old('name') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- username -->
                    <div class="mb-3">
                        <input type="text" id="username" name="username" class="form-control"
                               placeholder="Nama Panggilan">
                        @error('username')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- email -->
                    <div class="mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email MBAS"
                               value="{{ old('email') }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- phone -->
                    <div class="mb-3">
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Contact Number"
                               value="{{ old('phone') }}">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- department -->
                    <div class="mb-3">
                        @if(auth()->user()->hasRole('STAFF_BTM|KB_BTM'))
                            <input type="text" id="department" name="department" class="form-control"
                                   value="BHG TEKNOLOGI MAKLUMAT" readonly>
                        @elseif(!is_null($dep))
                            <input type="text" id="department" name="department" class="form-control"
                                   value="{{ $dep->name }}" readonly>
                        @else
                            <select id="department" name="department" class="form-control">
                                <option value="none">-- Nama Penuh Bahagian --</option>
                                @foreach($list as $l)
                                    @if($l->name !== 'Teknologi Maklumat')
                                        <option value="{{ $l->name }}">{{ $l->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                        @error('department')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- img -->
                    <div class="mb-3">
                        <label for="img">Gambar Profile</label>
                        <span style="font-size: 12px; color: grey; font-weight: bold;">* Tidak Diwajibkan</span>
                        <input type="file" id="img" name="img" class="form-control">
                        <span style="font-size: 12px; color: red; font-weight: bold;">* Maksimum saiz ialah 10MB</span>
                        @error('img')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit">Hantar</button>
                    <a href="{{ route('back') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
