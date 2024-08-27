<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Menukar Kata Laluan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        }

        .content {
            padding: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
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

            .btn {
                padding: 10px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Permintaan Menukar Kata Laluan</h1>
    </div>
    <div class="content">
        <p>Pengguna yang dihormati,</p>
        <p>Kami menerima permintaan untuk menetapkan semula kata laluan anda. Klik butang di bawah untuk menetapkan
            semula kata laluan anda.</p>
        <p>
            <a href="{{ route('pass_form',['token'=>$token]) }}" class="btn">Ubah kata laluan</a>
        </p>
        <p>Jika anda tidak meminta tetapan semula kata laluan, tiada tindakan lanjut diperlukan.</p>
        <p>Terima kasih,</p>
        <p>Pasukan {{ config('app.name') }} </p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
