<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderTicket;

class PaymentPage extends Component
{
    public $email;
    public $cardNumber;
    public $cardType;
    public $order;

    public function mount()
    {
        $this->order = session('checkout');

        if (!$this->order || empty($this->order['tickets'])) {
            session()->flash('error', 'Данные заказа отсутствуют.');
            return redirect()->route('tickets');
        }

        $this->email = $this->order['tickets'][0]['email'] ?? '';
    }

    public function updatedCardNumber()
    {
        $this->cardType = $this->detectCardType($this->cardNumber);
    }
    private function detectCardType($number)
    {
        $patterns = [
            'Visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'MasterCard' => '/^5[1-5][0-9]{14}$/',
            'Мир' => '/^220[0-4][0-9]{12}$/',
        ];

        foreach ($patterns as $type => $pattern) {
            if (preg_match($pattern, $number)) {
                return $type;
            }
        }

        return null;
    }

    public function processPayment()
    {
        $this->validate([
            'email' => 'required|email',
            'cardNumber' => 'required|numeric|digits_between:13,19',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Необходимо войти в систему.');
        }

        try {
            $order = Order::create([
                'card_id' => $this->order['cardId'],
                'tickets_count' => count($this->order['tickets']),
                'user_id' => Auth::id(),
            ]);

            foreach ($this->order['tickets'] as $ticket) {
                OrderTicket::create([
                    'order_id' => $order->id,
                    'name' => $ticket['name'],
                    'email' => $ticket['email'] ?? null,
                    'phone' => $ticket['phone'],
                ]);
            }

            session()->forget('checkout');;
            session()->flash('success', "Заказ #{$order->id} - {$order->card->title} успешно создан!");
            return redirect()->route('orders');
        } catch (\Exception $e) {
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
