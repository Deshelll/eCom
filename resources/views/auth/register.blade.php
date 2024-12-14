<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="">
    <div class="bg-white bg-opacity-90 rounded-lg p-8 w-full max-w-md shadow-lg backdrop-blur-lg">
        <h2 class="text-3xl font-bold mb-4 text-center text-gray-800">Регистрация</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="name" placeholder="Имя" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="text" name="surname" placeholder="Фамилия" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="text" name="patronymic" placeholder="Отчество" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="date" name="birth_date" placeholder="Дата рождения" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" placeholder="Email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" placeholder="Пароль" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-500" required>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="agree" id="agree" class="mr-2 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                <label for="agree" class="text-sm text-gray-600">Согласен с обработкой персональных данных</label>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Зарегистрироваться</button>

            <p class="mt-4 text-sm text-center text-gray-600">Уже есть аккаунт? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Войдите</a></p>
        </form>
    </div>
</div>
@endsection
