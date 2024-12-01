<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderTicket;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PaymentPage extends Component
{
    public $order = [];
    public $email;

    public function mount()
    {
        // Получаем данные из сессии
        $this->order = session()->get('checkout', []);

        if (empty($this->order)) {
            Log::error('Данные заказа отсутствуют в сессии.');
            return redirect()->route('tickets')->with('error', 'Данные заказа отсутствуют.');
        }

        Log::info('Данные из сессии:', $this->order);

        // Инициализация email для чека
        $this->email = $this->order['tickets'][0]['email'] ?? '';
        Log::info('Инициализация email для чека: ' . $this->email);
    }

    public function processPayment()
    {
        Log::info('Процесс оплаты начат.');

        if (!Auth::check()) {
            Log::error('Пользователь не авторизован.');
            return redirect()->route('login')->with('error', 'Необходимо войти в систему.');
        }

        $this->validate([
            'email' => 'required|email',
        ]);

        try {
            // Создание заказа
            $order = Order::create([
                'card_id' => $this->order['cardId'],
                'tickets_count' => count($this->order['tickets']),
                'user_id' => Auth::id(),
            ]);

            Log::info('Заказ создан:', ['order_id' => $order->id, 'user_id' => Auth::id()]);

            // Запись билетов в order_tickets
            foreach ($this->order['tickets'] as $ticket) {
                OrderTicket::create([
                    'order_id' => $order->id,
                    'name' => $ticket['name'],
                    'email' => $ticket['email'] ?? null,
                    'phone' => $ticket['phone'],
                ]);
            }

            session()->forget('checkout');
            session()->flash('success', 'Ваш заказ успешно оплачен!');
            return redirect()->route('orders');
        } catch (\Exception $e) {
            Log::error('Ошибка при обработке заказа: ' . $e->getMessage());
            session()->flash('error', 'Произошла ошибка при обработке заказа.');
        }
    }

    public function render()
    {
        return view('livewire.payment-page', [
            'order' => $this->order,
        ])->extends('layouts.main');
    }
}
