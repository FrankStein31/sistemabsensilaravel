<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body{
            background-image: url('{{ asset('img/smki.png') }}');
            background-size: 100% auto;
            background-repeat: no-repeat;
        }
        h1{
            font-size : 75px;
            color : #ffffff;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-block-start: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 0 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .testimonial-button {
            background-color: #3498db;
        }
        .login-button {
            background-color: #009688;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    @include('layouts.navbar')
    <br><br><br><br><br><br>
    <div class="centered-text">
        <h1>SI PRESTIK</h1>
        <div class="button-container">
            <a href="{{ route('login') }}" class="button login-button">Login</a>
        </div>
    </div>
</body>
</html>
