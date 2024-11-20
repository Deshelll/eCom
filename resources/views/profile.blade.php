@extends('layouts.main')

@section('title', 'Профиль')

@section('content')
    <!-- Блок для отображения ошибок -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6 max-w-2xl mx-auto">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Основной контент -->
    <div class="flex items-start mx-auto bg-white shadow-lg rounded-lg p-6 mt-8" style="max-width: 1000px;">
        <!-- Блок аватара с возможностью открытия модального окна -->
        <div class="relative w-48 h-48 bg-gray-200 rounded-full overflow-hidden shadow-md mr-10 cursor-pointer transition duration-300 transform hover:scale-105"
             onclick="toggleAvatarModal(true);" title="Нажмите для выбора аватара">
            @if(Auth::user()->avatar)
                <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
            @else
                <p class="absolute inset-0 flex items-center justify-center text-gray-500">Выбрать аватар</p>
            @endif
        </div>

        <!-- Информация о пользователе -->
        <div class="space-y-8 flex-grow">
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="text-gray-500 text-sm">Имя</label>
                    <p class="text-xl font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="text-gray-500 text-sm">Отчество</label>
                    <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->patronymic }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="text-gray-500 text-sm">Email</label>
                    <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <label class="text-gray-500 text-sm">Телефон</label>
                    <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->phone ?? 'Не указан' }}</p>
                </div>
            </div>

            <!-- Кнопки редактирования и смены пароля -->
            <div class="pt-4 flex space-x-4">
                <button onclick="toggleEditProfileModal(true);" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-300 transform hover:scale-105">
                    Редактировать профиль
                </button>
                <button onclick="togglePasswordModal(true);" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-300 transform hover:scale-105">
                    Сменить пароль
                </button>
            </div>
        </div>
    </div>

    <!-- Модальное окно для выбора аватара -->
    <div id="avatarModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Выберите аватар</h3>
            <div class="grid grid-cols-3 gap-4 mb-4">
                @foreach(['avatar1.png', 'avatar2.png', 'avatar3.png'] as $avatar)
                    <form action="{{ route('profile.uploadAvatar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="avatar" value="{{ $avatar }}">
                        <button type="submit" class="w-24 h-24 rounded-full overflow-hidden border-2 @if(Auth::user()->avatar == $avatar) border-blue-500 @else border-gray-300 @endif transition duration-300 transform hover:scale-105">
                            <img src="{{ asset('avatars/' . $avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        </button>
                    </form>
                @endforeach
            </div>
            <button onclick="toggleAvatarModal(false);" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 mt-2">
                Закрыть
            </button>
        </div>
    </div>

    <!-- Модальное окно для смены пароля -->
    <div id="passwordModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Сменить пароль</h3>
            <form action="{{ route('profile.updatePassword') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-600 text-sm">Текущий пароль</label>
                    <input type="password" name="current_password" id="current_password" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-600 text-sm">Новый пароль</label>
                    <input type="password" name="new_password" id="new_password" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-gray-600 text-sm">Подтвердите новый пароль</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="togglePasswordModal(false);" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Отмена</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Модальное окно для редактирования профиля -->
    <div id="editProfileModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Редактировать профиль</h3>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 text-sm">Имя</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="patronymic" class="block text-gray-600 text-sm">Отчество</label>
                    <input type="text" name="patronymic" id="patronymic" value="{{ Auth::user()->patronymic }}" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 text-sm">Email</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-600 text-sm">Телефон</label>
                    <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="+7 (___) ___-__-__" oninput="formatPhoneNumber(this)">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="toggleEditProfileModal(false);" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Отмена</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAvatarModal(show) {
            document.getElementById('avatarModal').style.display = show ? 'flex' : 'none';
        }
        function togglePasswordModal(show) {
            document.getElementById('passwordModal').style.display = show ? 'flex' : 'none';
        }
        function toggleEditProfileModal(show) {
            document.getElementById('editProfileModal').style.display = show ? 'flex' : 'none';
        }
        
        // Автоформатирование телефона
        function formatPhoneNumber(input) {
            const cleaned = input.value.replace(/\D/g, '');
            const match = cleaned.match(/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/);
            if (match) {
                input.value = `+${match[1]} (${match[2]}) ${match[3]}-${match[4]}-${match[5]}`;
            }
        }
    </script>
@endsection