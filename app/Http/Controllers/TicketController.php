<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Получаем все данные из таблицы cards
        $cards = Card::all();

        // Проверяем, загружены ли данные
        if ($cards->isEmpty()) {
            logger('Таблица cards пуста');
        } else {
            logger('Загружены карточки: ', $cards->toArray());
        }

        // Передаем данные в шаблон
        return view('tickets', compact('cards'));
    }
}
