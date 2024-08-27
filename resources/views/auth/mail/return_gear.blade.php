@php use App\Models\Gear; @endphp
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Menukar Kata Laluan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            text-align: left;
            font-size: 16px;
            line-height: 1.5;
        }

        .content p {
            margin: 20px 0;
        }

        .content {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #e9ecef;
            font-size: 12px;
            color: #6c757d;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .header h1 {
                font-size: 20px;
            }

            .content {
                font-size: 14px;
            }

            .footer {
                font-size: 10px;
            }

            .content {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Pengembalian Peralatan ICT</h1>
    </div>
    <div class="content">
        <p>Pengguna yang dihormati,</p>
        <p>
            Pinjaman peralatan ICT telah tamat tempoh
            pada {{ (DateTime::createFromFormat('Y-m-d', $brrw->end))->format('d-m-Y') }}.
            Diminta tuan/puan membuat <b>pengembalian peralatan</b> yang telah dipinjam di bahagian teknologi maklumat
            dalam keadaan <b>segera</b>. Kerjasama anda kami hargai. <br> Sekian Terima Kasih.
        </p>
        <p>
            <b>Butiran Pinjaman:</b><br><br>
            Id Pinjaman: {{$brrw->tiket}} <br>
            Peminjam: {{ strtoupper($brrw->application->name) }} <br>
            Peralatan: <br>
            @foreach($gear as $g)
                @php $details = Gear::whereId($g)->first(); @endphp
                {{$loop->iteration}}. <b>{{$details->type}}</b> - {{$details->tag}} <br>
            @endforeach
        </p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
