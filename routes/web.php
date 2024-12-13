<?php

use App\Livewire\Rental;
use App\Livewire\RentalCheckoutForm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;

use App\Livewire\Tickets;
use App\Livewire\CheckoutForm;
use App\Livewire\PaymentPage;

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

Route::get('/rental', Rental::class)->name('rental');

Route::get('/orders', \App\Livewire\Orders::class)->name('orders');

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

Route::get('/login/auth/yandex', [LoginController::class, 'redirectToYandex'])->name('login.yandex');
Route::get('/login/auth/yandex/callback', [LoginController::class, 'handleYandexCallback']);

//карточки
Route::get('/tickets', Tickets::class)->name('tickets');

//ввод данных для покупки билетов
Route::middleware('auth')->group(function () {
    Route::get('/checkout/{cardId}', \App\Livewire\CheckoutForm::class)->name('checkout');

    Route::get('rental/checkout/{rentalCardId}', RentalCheckoutForm::class)->name('rental.checkout');
});

//оплата
Route::get('/payment', PaymentPage::class)->name('payment');
Route::delete('/cards/{id}', \App\Livewire\Tickets::class . '@deleteCard')->name('cards.destroy');

