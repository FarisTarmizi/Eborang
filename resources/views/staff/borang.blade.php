@php use App\Models\Gear; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang Permohonan Peralatan ICT</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Calibri, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            text-align: justify;
        }

        h3 {
            background-color: lightgrey;
            margin: 0;
            padding: 5px;
        }

        .container {
            padding: 10px;
            box-sizing: border-box;
        }

        .header, .section, .approval-section {
            margin-bottom: 10px;
        }

        .section, .approval-section {
            margin-top: 25px;
        }

        .header {
            text-align: center;
        }

        .header img {
            max-width: 80px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
            margin-bottom: 10px;
        }

        .header th, .header td {
            padding: 5px;
            border: 2px solid #000;
            text-align: center;
        }

        .approval-section {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .approval-section div {
            box-sizing: border-box;
        }

        table, .table {
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table, .table {
            width: 100%;
        }


        .table, .th, .td {
            border: 1px solid #000;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        .table-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="container">
    <div style=" font-size: 20px; width: 30%;padding: 1% ; margin-bottom: 5%">
        <b> {{$data->tiket}} </b>
    </div>
    <div class="header">
        <table>
            <tr>
                <td>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/94/Jata_MalaysiaV2.svg" alt="Logo 1">
                </td>
                <td colspan="3" style="font-size: 18px">
                    <b> LAMPIRAN 1: <br> BORANG PERMOHONAN PERALATAN ICT </b>
                </td>
                <td>
                    <img src="https://seeklogo.com/images/M/mbas-logo-6262A38504-seeklogo.com.png" alt="Logo 2">
                </td>
            </tr>
        </table>
    </div>
    <div class="section">
        <h4>Perhatian:</h4>
        <ol>
            <li>Sila mohon pinjaman peralatan lima (5) hari sebelum tarikh dipinjam.</li>
            <li>Permohonan akan disemak dan status kelulusan akan diberikan dalam masa dua (2) hari.</li>
            <li>Adalah menjadi tanggungjawab pemohon untuk memastikan semua maklumat / data dipadam atau dipindahkan
                sepenuhnya daripada peralatan.
            </li>
        </ol>
    </div>
    <div class="section">
        <h3>MAKLUMAT PEMOHON</h3>
        <table>
            <tr>
                <th>Id Pekerja</th>
                <td>: {{$data->user_id}}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>: {{strtoupper($user->name)}}</td>
            </tr>
            <tr>
                <th>Bahagian</th>
                <td>: {{$user->department}}</td>
            </tr>
            <tr>
                <th>No. Tel</th>
                <td>: {{$user->phone}}</td>
            </tr>
            <tr>
                <th>Emel (jika ada)</th>
                <td>: {{$user->email}}</td>
            </tr>
            <tr>
                <th>Tarikh Penggunaan</th>
                @php
                    $start = DateTime::createFromFormat('Y-m-d', $data->start);
                    $end = DateTime::createFromFormat('Y-m-d', $data->end);
                @endphp
                <td>: {{$start->format('d-m-Y')}} hingga {{$end->modify('-1 day')->format('d-m-Y')}} </td>
            </tr>
            <tr>
                <th>Tujuan Permohonan</th>
                <td>: {{$data->motive}}</td>
            </tr>
        </table>
    </div>
    <div class="section table-container">
        <table class="table">
            <tr>
                <th class="th">Bil.</th>
                <th class="th">Jenis Peralatan</th>
                <th class="th">Model</th>
                <th class="th">No Siri</th>
                <th class="th">Bo. Tag BTM</th>

            </tr>
            @php
                $gear = [];
                $g = explode(', ', $data->gear_id);
                foreach ($g as $item) {
                    $gear[] = Gear::whereId($item)->first();
                }
            @endphp
            @foreach($gear as $i)
                <tr>
                    <td class="td">{{$loop->iteration}}</td>
                    <td class="td">{{$i->type}}</td>
                    <td class="td">{{$i->model}}</td>
                    <td class="td">{{$i->no_siri}}</td>
                    <td class="td">{{$i->tag}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="section">
        <h3>ULASAN PERMOHONAN</h3>
        <table>
            <tr>
                <th>Bahagian</th>
                <td>: {{strtoupper($dept->name)}}</td>
            </tr>
            <tr>
                <th>Nama Ketua Bahagian</th>
                <td>: {{strtoupper($dept->leader)}}</td>
            </tr>
            <tr>
                <th>Tarikh</th>
                @php
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                $date = explode(', ',$data->verify_at);
                $verify1 = DateTime::createFromFormat('Y-m-d H:i:s', $date[0]); //KB BHG LAIN
                $verify2 = DateTime::createFromFormat('Y-m-d H:i:s', $date[1]); //KB BTM

                @endphp
                <td>: {{$verify1->format('d-m-Y')}}</td>
            </tr>
            <tr>
                <th>Masa</th>
                <td>: {{$verify1->format('H:i')}}</td>
            </tr>
            <tr>
                <th>Lokasi Peralatan Digunakan</th>
                <td>: {{$data->location}}</td>
            </tr>
            <tr>
                <th>Ulasan permohonan</th>
                <td>: {{$data->review}}</td>
            </tr>
        </table>
    </div>

    <div class="section approval-section">
        <div>
            <h3>KELULUSAN KETUA BAHAGIAN TEKNOLOGI MAKLUMAT</h3>
        </div>
        <div>
            <table>
                <tr>
                    <td>Kelulusan: <b> Diluluskan </b></td>
                    <td>Tarikh: {{$verify2->format('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td>Nama: MUHAMMAD ANAS BIN ABD RAHIM</td>
                    <td>Tandatangan:</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>
