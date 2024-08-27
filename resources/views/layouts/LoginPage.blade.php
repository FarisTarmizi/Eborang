<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('image/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('lte/plugins/fontawesome-free/css/all.min.css')}}">

    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css
" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap" rel="stylesheet">
    <style>
        input, select {
            caret-color: rgb(138, 138, 138);
        }

        body {
            background: url("{{asset('image/loginwall.jpg')}}") no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            padding: 10px; /* Added padding for better spacing on smaller screens */
        }

        .container, .container2, .container3 {
            position: relative;
            border-radius: 20px;
            padding: 40px;
            box-sizing: border-box;
            background: #ecf0f3;
            box-shadow: 14px 14px 20px #d5d4d4c6, -14px -14px 20px #d5d4d4c6;
            margin-top: 10%; /* Adjusted margin-top for smaller screens */
        }

        .container {
            width: 90%; /* Changed width to be more flexible */
            max-width: 350px;
            height: auto; /* Adjusted height to be more flexible */
        }

        .container2 {
            width: 90%; /* Changed width to be more flexible */
            max-width: 800px;
            height: auto; /* Adjusted height to be more flexible */
        }

        .container3 {
            width: 90%; /* Changed width to be more flexible */
            max-width: 400px;
            height: auto; /* Adjusted height to be more flexible */
            margin-top: 3%;
        }

        .brand-logo {
            height: 100px;
            width: 100px;
            margin: auto;
            border-radius: 50%;
            box-sizing: border-box;
            box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
        }

        .brand-title {
            margin-top: 10px;
            font-weight: 600;
            font-size: 20px;
            color: #1DA1F2;
            letter-spacing: 1px;
        }

        .inputs {
            text-align: left;
            margin-top: 30px;
        }

        input, select, button, a {
            display: block;
            width: 100%;
            margin-bottom: 14px;
            padding: 0;
            border: none;
            outline: none;
            box-sizing: border-box;
        }

        input::placeholder, select {
            color: rgba(106, 101, 101, 0.645);
        }

        input, select {
            background: #ecf0f3;
            padding: 10px 20px;
            height: 50px;
            font-size: 14px;
            border-radius: 50px;
            box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px white;
        }

        button, a {
            font-size: 17px;
            margin-top: 20px;
            color: white;
            background: #1DA1F2;
            height: 40px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 900;
            box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
            transition: 0.5s;
        }
        .a{
            background-color: transparent;
            color: black;
            font-family: Calibri,sans-serif;
            box-shadow: none;
            border-radius:0;
        }
        button:hover, a:hover {
            box-shadow: none;
        }

        a {
            font-size: 16px;
            padding-top: 1%;
            text-align: center;
            text-decoration: none;
        }

        h1 {
            position: absolute;
            top: 0;
            left: 0;
        }

        @media (max-width: 768px) {
            .container, .container2, .container3 {
                width: 95%;
                padding: 20px;
            }

            .container {
                max-width: 300px;
            }

            .container2 {
                max-width: 600px;
            }

            .container3 {
                max-width: 350px;
            }

            .brand-title {
                font-size: 18px;
            }

            button, a {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .container, .container2, .container3 {
                width: 100%;
                padding: 15px;
            }

            .brand-logo {
                height: 80px;
                width: 80px;
            }

            .brand-title {
                font-size: 16px;
            }

            input, select {
                height: 45px;
                font-size: 12px;
            }

            button, a {
                height: 35px;
                font-size: 14px;
            }
        }

    </style>
</head>
<body>
@yield('test')
</body>
</html>
