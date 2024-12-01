<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Метод для отображения формы авторизации
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Метод для обработки данных при попытке входа
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('profile');
        }

        return back()->withErrors([
            'email' => 'Неправильный логин или пароль.',
        ]);
    }

    // Перенаправление на Google для аутентификации
    public function redirectToGoogle()
    {
        $redirectUri = sprintf('%s/auth/google/callback', request()->getSchemeAndHttpHost());

        return Socialite::driver('google')
            ->with(['redirect_uri' => $redirectUri])
            ->redirect();
    }

    // Обработка ответа от Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Логируем данные, полученные от Google
            Log::info('Google User Data:', [
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            // Проверяем, существует ли пользователь с таким email
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                Log::info('Existing user found, logging in:', ['email' => $existingUser->email]);
                Auth::login($existingUser);
            } else {
                Log::info('Creating a new user.', [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]);

                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'surname' => '', // Значение по умолчанию
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'avatar' => $googleUser->getAvatar(),
                    'birth_date' => now()->toDateString(), // Текущая дата по умолчанию
                ]);

                if ($newUser) {
                    Log::info('New user created successfully:', ['email' => $newUser->email]);
                } else {
                    Log::error('Failed to create a new user in the database.');
                    return redirect()->route('login')->with('error', 'Ошибка при создании пользователя.');
                }

                Auth::login($newUser);
            }

            return redirect()->intended('/profile');
        } catch (Exception $e) {
            Log::error('Google Login Error:', ['message' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Не удалось войти через Google.');
        }
    }
    // Перенаправление на Яндекс для аутентификации
    public function redirectToYandex()
    {
        try {
            // Логируем вход в метод
            Log::info('Entering redirectToYandex');

            // Логируем информацию о текущем состоянии приложения
            Log::info('Environment variables:', [
                'YANDEX_CLIENT_ID' => env('YANDEX_CLIENT_ID'),
                'YANDEX_REDIRECT_URI' => env('YANDEX_REDIRECT_URI'),
            ]);

            // Логируем попытку работы с драйвером
            Log::info('Attempting to use Yandex driver');

            return Socialite::driver('yandex')->redirect();
        } catch (Exception $e) {
            // Логируем исключение
            Log::error('Error during Yandex redirection:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')->withErrors('Ошибка при редиректе на Яндекс.');
        }
    }

    // Обработка ответа от Яндекса
    public function handleYandexCallback()
    {
        try {
            $yandexUser = Socialite::driver('yandex')->stateless()->user();

            // Логируем данные, полученные от Яндекса
            Log::info('Yandex User Data:', [
                'id' => $yandexUser->getId(),
                'name' => $yandexUser->getName(),
                'email' => $yandexUser->getEmail(),
            ]);

            // Проверяем, существует ли пользователь с таким email
            $existingUser = User::where('email', $yandexUser->getEmail())->first();

            if ($existingUser) {
                Log::info('Existing user found, logging in:', ['email' => $existingUser->email]);
                Auth::login($existingUser);
            } else {
                Log::info('Creating a new user.', [
                    'name' => $yandexUser->getName(),
                    'email' => $yandexUser->getEmail(),
                    'yandex_id' => $yandexUser->getId(),
                ]);

                $newUser = User::create([
                    'name' => $yandexUser->getName(),
                    'surname' => '', // Значение по умолчанию
                    'email' => $yandexUser->getEmail(),
                    'yandex_id' => $yandexUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]);

                if ($newUser) {
                    Log::info('New user created successfully:', ['email' => $newUser->email]);
                } else {
                    Log::error('Failed to create a new user in the database.');
                    return redirect()->route('login')->with('error', 'Ошибка при создании пользователя.');
                }

                Auth::login($newUser);
            }

            return redirect()->intended('/profile');
        } catch (Exception $e) {
            Log::error('Yandex Login Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->withErrors('Не удалось войти через Яндекс.');
        }
    }

    // Метод для перенаправления неаутентифицированных пользователей
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
