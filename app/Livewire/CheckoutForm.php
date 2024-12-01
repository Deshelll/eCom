<?php

namespace App\Livewire;

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
    public $quantity = 1;

    public function mount($cardId)
    {
        $this->card = Ticket::find($cardId);

        if (!$this->card) {
            abort(404, 'Карточка не найдена.');
        }

        $this->tickets[] = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'quantity' => 1,
        ];
    }

    public function addTicket()
    {
        $this->tickets[] = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'quantity' => 1,
        ];
    }

    public function removeTicket($index)
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
        $this->validate([
            'tickets.*.name' => 'required|string|max:255',
            'tickets.*.email' => 'required|email|max:255',
            'tickets.*.phone' => 'required|string|max:20',
            'tickets.*.quantity' => 'required|integer|min:1|max:' . $this->card->available_tickets,
        ]);

        try {
            session()->put('checkout', [
                'cardId' => $this->card->id,
                'tickets' => $this->tickets,
            ]);
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
