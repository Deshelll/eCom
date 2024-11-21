<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;

use App\Livewire\Tickets;
use App\Livewire\CheckoutForm;

// Главная страница
Route::get('/', Tickets::class)->name('home');

// Показ форм регистрации и входа через методы контроллеров
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');    // Форма входа

// Обработка данных регистрации и входа
Route::post('/register', [RegisterController::class, 'register'])->name('register.post'); // Обработка регистрации
Route::post('/login', [LoginController::class, 'login'])->name('login.post');          // Обработка входа

// Роуты для профиля
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.uploadAvatar');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

//Главный шаблон
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // перенаправление на главную после выхода
})->name('logout');

//Маршруты вертикального меню

Route::get('/rental', function () {
    return view('rental');
})->name('rental');

Route::get('/orders', function () {
    return view('orders');
})->name('orders');
Route::middleware('auth')->group(function () {
    Route::get('/support', function () {
        return view('support');
    })->name('support');
});

// Отправка обращения на почту
Route::post('/support/submit', [SupportController::class, 'submit'])->name('support.submit');

//Авторизация Google
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

//карточки
Route::get('/tickets', Tickets::class)->name('tickets');

//оплата
//Route::get('/checkout/{card}', CheckoutForm::class)->name('checkout');
Route::get('/checkout/{cardId}', CheckoutForm::class)->name('checkout');








