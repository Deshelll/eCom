<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\Order;
use App\Models\Ticket;
use Exception;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckoutForm extends Component
{
    public $tickets = [];
    public $name;
    public $phone;
    public $card;
    public $email;
    public $order;

    public function mount($cardId): void
    {
        //$this->card = Ticket::find($cardId);
        $this->card = Card::with('tickets')->find($cardId);

        if (!$this->card) {
            abort(404, 'Карточка не найдена.');
        }

        $this->tickets[] = [
            'id' => $this->card->id,
            'name' => '',
            'email' => '',
            'phone' => '',
            'quantity' => 1,
        ];
    }

    public function addTicket(): void
    {
        $this->tickets[] = [
            'id' => $this->card->id,
            'name' => '',
            'email' => '',
            'phone' => '',
            'quantity' => 1,
        ];
    }

    public function removeTicket($index): void
    {
        unset($this->tickets[$index]);
        $this->tickets = array_values($this->tickets); // Сбрасываем ключи
    }

    public function checkAvailability()
    {
        // Проверяем доступность билетов
        foreach ($this->tickets as $ticket) {
            $available = Ticket::find($ticket['id']);
            if (!$available || $available->available_tickets < $ticket['quantity']) {
                session()->flash('error', 'Недостаточно билетов для "' . $available->title . '".');
                return;
            }
        }

        // Если билеты доступны, перенаправляем на страницу оплаты
        return redirect()->route('payment', ['tickets' => $this->tickets]);
    }
    public function submit()
    {
        $maxTickets = $this->card->ticket->available_tickets ?? PHP_INT_MAX;

        $this->validate([
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.email' => 'required|email|max:255',
            'tickets.*.phone' => 'required|string|max:20',
            'tickets.*.quantity' => 'required|integer|min:1|max:' . $maxTickets,
        ]);

        $totalPrice = 0;
        foreach ($this->tickets as $ticket) {
            $totalPrice += $ticket['quantity'] * $this->card->price;
        }

        try {
            session()->put('checkout', [
                'cardId' => $this->card->id,
                'tickets' => $this->tickets,
                'totalPrice' => $totalPrice,
            ]);

            Log::info('Итоговая сумма: ' . $totalPrice);

        } catch (Exception $e) {
            throw $e;
        }

        try {
            return redirect()->route('payment');
        } catch (Exception $e) {
            Log::error('Ошибка редиректа: ' . $e->getMessage());
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.checkout-form', [
            'availableTickets' => Ticket::all(),
            'card' => $this->card,
        ])->extends('layouts.main');
    }
}
