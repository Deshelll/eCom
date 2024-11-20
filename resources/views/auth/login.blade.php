@extends('layouts.app')

@section('title', 'Авторизация')

@section('content')
<div class="flex items-center justify-center bg-gray-100 min-h-screen">
    <div class="shadow-md rounded-lg p-8 w-full max-w-sm bg-white">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Авторизация</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email -->
            <div class="mb-5">
                <input type="email" name="email" id="email" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <!-- Пароль -->
            <div class="mb-5">
                <input type="password" name="password" id="password" placeholder="Пароль" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <!-- Кнопка входа -->
            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Войти</button>

            <!-- Кнопки для входа через Google и Apple -->
            <div class="mt-6">
                <a href="{{ route('login.google') }}" class="w-full flex items-center justify-center border border-gray-300 text-gray-700 py-2 rounded-lg mb-3 hover:bg-gray-100 focus:outline-none">
                    <img src="/images/google.png" alt="Google" class="w-5 h-5 mr-2">
                    Войти через Google
                </a>
                <button type="button" class="w-full flex items-center justify-center border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                    <img src="/images/apple.png" alt="Apple" class="w-5 h-5 mr-2">
                    Войти через Apple
                </button>
            </div>

            <!-- Ссылка на регистрацию -->
            <p class="mt-4 text-sm text-center text-gray-600">Нет аккаунта? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Зарегистрируйтесь</a></p>
        </form>
    </div>
</div>
@endsection