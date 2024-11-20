<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    // Показ профиля
    public function show()
    {
        $user = Auth::user(); // Получаем текущего аутентифицированного пользователя
        return view('profile', compact('user')); // Передаем пользователя в представление
    }

    // Загрузка нового аватара
        public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|string',
        ]);

        $user = Auth::user();
        $user->avatar = $request->avatar;
        $user->save();

        return redirect()->route('profile')->with('success', 'Аватар успешно обновлен');
    }
    public function updatePassword(Request $request)
    {

        // Валидация данных
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);


        $user = Auth::user();

        // Проверка текущего пароля
        if (!Hash::check($request->current_password, $user->password)) {
            dd('Неверный текущий пароль');
            return back()->withErrors(['current_password' => 'Текущий пароль неверен']);
        }

        // Обновление пароля
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Пароль успешно обновлен');
    }
    public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'patronymic' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'phone' => 'nullable|string|max:20',
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'patronymic' => $request->patronymic,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return redirect()->route('profile')->with('success', 'Профиль успешно обновлен');
}
}