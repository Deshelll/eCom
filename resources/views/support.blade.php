<!-- resources/views/support.blade.php -->
@extends('layouts.main')

@section('title', 'Поддержка')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl mx-auto mt-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Связаться с поддержкой</h1>
        <p class="text-gray-600 text-center mb-6">Если у вас есть вопросы или предложения, заполните форму ниже.</p>

        <form id="supportForm" action="{{ route('support.submit') }}" method="POST" class="space-y-6" onsubmit="showConfirmationModal(event)">
            @csrf

            <div>
                <label for="name" class="block text-sm text-gray-600">Имя</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="w-full mt-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            </div>


            <div>
                <label for="email" class="block text-sm text-gray-600">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="w-full mt-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
            </div>


            <div>
                <label for="subject" class="block text-sm text-gray-600">Тема</label>
                <input type="text" name="subject" id="subject" placeholder="Кратко опишите тему обращения" class="w-full mt-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>


            <div>
                <label for="message" class="block text-sm text-gray-600">Сообщение</label>
                <textarea name="message" id="message" rows="4" placeholder="Подробно опишите ваш вопрос или предложение" class="w-full mt-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-3 px-6 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none transition duration-300">Отправить обращение</button>
            </div>
        </form>
    </div>

    <div id="confirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-sm w-full">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Обращение отправлено</h2>
            <p class="text-gray-600">Спасибо за обращение. Мы свяжемся с вами в ближайшее время.</p>
            <button onclick="closeConfirmationModal()" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none">Закрыть</button>
        </div>
    </div>

    <script>
        function showConfirmationModal(event) {
            event.preventDefault(); // Предотвращаем отправку формы для демонстрации
            document.getElementById('confirmationModal').style.display = 'flex';
        }

        function closeConfirmationModal() {
            document.getElementById('confirmationModal').style.display = 'none';
            document.getElementById('supportForm').submit(); // Отправка формы
        }
    </script>
@endsection
