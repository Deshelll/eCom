<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: white;
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="w-full max-w-md mx-auto p-8 rounded-lg">
    @yield('content')

</div>
</body>
</html>
