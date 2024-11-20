<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $googleUser = Socialite::driver('google')->user();

            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)) // Обновлено на Str::random(16)
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('/profile');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Не удалось войти через Google');
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