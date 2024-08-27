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
@section('page','DASHBOARD')
@section('content')
    @if(Session::has('welcome'))
        <script>
            Swal.fire({
                title: "Selamat Datang",
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
                title: "Ralat",
                text: "{{ Session::get('error') }}",
                icon: "error"
            });
        </script>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <div class="row mx-auto bg-white mt-8 -mb-8 font-bold">
        <h3 class="mb-3 text-center col-lg-6 ">PERMOHONAN</h3>
        <h3 class="mb-3 text-center col-lg-6 ">PINJAMAN</h3>
    </div>
    <div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
    <div class="row mx-auto">
        <div class="col-lg-6 ">
            <div class="small-box bg-gradient-yellow">
                <div class="inner text-white">
                    <h3>{{$action}}</h3>
                    <p>PERLU TINDAKAN SEGERA</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <a href="{{route('staff.application')}}" class="small-box-footer">
                    Lihat Lanjut
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-6 ">
            <div class="small-box bg-gradient-red">
                <div class="inner">
                    <h3>{{sizeof($over)}}</h3>
                    <p>LEBIH TEMPOH MASA</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <a href="{{route('staff.application')}}" class="small-box-footer">
                    Lihat Lanjut
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col-lg-6 ">
            <div class="small-box bg-gradient-green">
                <div class="inner">
                    <h3>{{$progres}}</h3>
                    <p>PERLU TINDAKAN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <a href="{{route('staff.application')}}" class="small-box-footer">
                    Lihat Lanjut
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-6 ">
            <div class="small-box bg-gradient-blue">
                <div class="inner">
                    <h3>{{sizeof($brrw)}}</h3>
                    <p>DALAM PINJAMAN</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <a href="{{route('staff.application')}}" class="small-box-footer">
                    Lihat Lanjut
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
  
<div class="box p-5 mx-auto my-auto bg-white bg-opacity-50">
    <h3 class="mb-8 text-center font-bold bg-white">PERALATAN</h3>
    <div class="row">
        <div class="card card-dark col-lg-6">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title" style="width: 12%">LAPTOP</h3>
                <i class="fas fa-laptop text-white"></i>
            
            </div>
            <div class="card-body bg-gradient-dark">
                <canvas id="pieChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
        <div class="card card-dark col-lg-6">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title" style="width: 18%">PROJEKTOR</h3>
                <i class="fas fa-hdd"></i>
                
            </div>
            <div class="card-body bg-gradient-dark">
                <canvas id="pieChart2"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div> 

@endsection
@section('chart')
    <script>
        $(document).ready(function () {
            // Example data for the pie chart
            var a_pc = ({{sizeof($a_pc)}} / {{sizeof($pc)}}) * 100;
            var n_pc = ({{sizeof($b_pc)}} / {{sizeof($pc)}}) * 100;
            var donutData = {
                labels: ['Tersedia - ' + a_pc.toFixed(1) + '%', 'Dipinjam - ' + n_pc.toFixed(1) + '%'],
                datasets: [{
                    data: [{{sizeof($a_pc)}}, {{sizeof($b_pc)}}],
                    backgroundColor: ['#33f133', '#de2525'],
                    hoverBackgroundColor: ['#33f133', '#de2525']
                }]
            };

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    labels: {
                        fontColor: 'white'
                    }
                },
                tooltips: {
                    bodyFontColor: 'white',
                    titleFontColor: 'white'
                },
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: donutData,
                options: pieOptions
            });
        });
        $(document).ready(function () {
            // Example data for the pie chart
            var a_pro = ({{sizeof($a_pro)}} / {{sizeof($pro)}}) * 100;
            var n_pro = ({{sizeof($b_pro)}} / {{sizeof($pro)}}) * 100;
            var donutData = {
                labels: ['Tersedia - ' + a_pro.toFixed(1) + '%', 'Dipinjam - ' + n_pro.toFixed(1) + '%'],
                datasets: [{
                    data: [{{sizeof($a_pro)}}, {{sizeof($b_pro)}}],
                    backgroundColor: ['#33f133', '#de2525'],
                    hoverBackgroundColor: ['#33f133', '#de2525']
                }]
            };

            var pieChartCanvas = $('#pieChart2').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    labels: {
                        fontColor: 'white'
                    }
                },
                tooltips: {
                    bodyFontColor: 'white',
                    titleFontColor: 'white'
                }
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: donutData,
                options: pieOptions
            });
        });
    </script>
@endsection
