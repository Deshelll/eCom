<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'patronymic' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'agree' => 'accepted'
    ]);

    // Создаем пользователя
    $user = User::create([
        'name' => $validatedData['name'],
        'surname' => $validatedData['surname'],
        'patronymic' => $validatedData['patronymic'],
        'birth_date' => $validatedData['birth_date'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Авторизация пользователя
    Auth::login($user);

    // Перенаправление на главную страницу
    return redirect('/');
}
}