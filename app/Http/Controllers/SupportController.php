<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        // Отправка email на указанный адрес
        Mail::send([], [], function ($message) use ($request, $user) {
            $message->from(config('mail.from.address'), config('mail.from.name'))
                ->to('gosha.balashov.1000@gmail.com') // Адрес получателя
                ->subject('Новое обращение: ' . $request->subject)
                ->text("
                    Имя: {$user->name}
                    Email: {$user->email}
                    Сообщение:\n{$request->message}
                ");
        });

        return redirect()->back()->with('success', 'Обращение отправлено');
    }
}