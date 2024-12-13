<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Боковое меню -->
    <aside class="bg-white w-64 p-6 shadow-lg flex flex-col justify-between items-start space-y-6">
        <!-- Верхняя часть бокового меню -->
        <div class="w-full">
            <!-- Аватар и имя пользователя -->
<a href="{{ Auth::check() ? route('profile') : route('login') }}" class="flex items-center space-x-4 mb-6 ml-2">
    <!-- Круглый аватар с проверкой на наличие -->
    <div class="w-16 h-16 bg-gray-300 rounded-full overflow-hidden">
        @if(Auth::check() && Auth::user()->avatar)
            <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
        @else
            <div class="flex items-center justify-center h-full text-gray-500">
                <!-- Иконка заглушка -->
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 12a5 5 0 100-10 5 5 0 000 10zM10 14a7 7 0 00-6.928 5.074A8 8 0 0118 14h-8z" clip-rule="evenodd"/>
                </svg>
            </div>
        @endif
    </div>

    <!-- Имя пользователя или надпись "Гость" -->
    <span class="text-gray-800 font-semibold text-lg">
        {{ Auth::check() ? Auth::user()->name : 'Гость' }}
    </span>
</a>

            <!-- Пункты меню -->
            <nav class="w-full">
                <a href="{{ route('home') }}" class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-200 transition">Билеты</a>
                <a href="{{ route('rental') }}" class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-200 transition">Аренда</a>
                <a href="{{ route('orders') }}" class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-200 transition">Мои заказы</a>
                <a href="{{ route('support') }}" class="block py-3 px-4 rounded-lg text-gray-700 hover:bg-gray-200 transition">Поддержка</a>
            </nav>
        </div>

        <!-- Кнопка выхода, только если пользователь аутентифицирован -->
        @if(Auth::check())
            <form action="{{ route('logout') }}" method="POST" class="w-full mt-auto">
                @csrf
                <button type="submit" class="flex items-center w-full py-3 px-4 mt-6 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition">
                    <span>Выход</span>
                    <svg class="w-5 h-5 ml-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0V5a3 3 0 016 0v1" />
                    </svg>
                </button>
            </form>
        @endif
    </aside>

    <!-- Основной контент -->
    <main class="flex-grow p-8 bg-gray-50 ml-4 rounded-lg shadow-md">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    @livewireScripts
</body>
</html>
