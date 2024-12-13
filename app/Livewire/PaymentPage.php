<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderTicket;
use App\Models\RentalOrder;
use App\Models\RentalTime;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentPage extends Component
{
    public $email;
    public $cardNumber;
    public $cardType;
    public $order;
    public $type;

    public function mount()
    {
        $this->selectedTickets = session()->get('checkout')['tickets'] ?? [];
        $this->order = session()->get('checkout', []);

        if (empty($this->order)) {
            Log::error('Данные заказа отсутствуют в сессии.');
            return redirect()->route('tickets')->with('error', 'Данные заказа отсутствуют.');
        }

        $this->type = $this->order['type'] ?? 'ticket';
        $this->email = $this->order['email'] ?? '';

        $this->totalPrice = $this->order['totalPrice'] ?? 0;
    }

    public function processTickets(): void
    {
        try {
            $order = Order::create([
                'card_id' => $this->order['cardId'],
                'tickets_count' => count($this->order['tickets']),
                'user_id' => Auth::id(),
            ]);

            foreach ($this->order['tickets'] as $ticket) {
                $ticketPaid = rand(0, 100) < 80;
                $status = $ticketPaid ? 'Оплачено' : 'Не оплачено';

                OrderTicket::create([
                    'order_id' => $order->id,
                    'name' => $ticket['name'],
                    'email' => $ticket['email'] ?? null,
                    'phone' => $ticket['phone'],
                    'status' => $status,
                ]);

                $ticketModel = Ticket::find($ticket['id']);
                if ($ticketModel && $ticketPaid) {
                    $ticketModel->decrement('available_tickets', $ticket['quantity']);
                }
            }

            session()->forget('checkout');
            session()->flash('success', "Заказ #{$order->id} успешно оплачен!");
            redirect()->route('orders');
            return;
        } catch (\Exception $e) {
            session()->flash('error', 'Произошла ошибка при обработке заказа.');
        }
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

        $isPaid = rand(0, 100) < 90;

        try {
            if ($this->type === 'rental') {
                $this->processRental($isPaid);
            } else {
                $this->processTickets($isPaid);
            }
        } catch (\Exception $e) {
            Log::error('Ошибка при обработке заказа: ' . $e->getMessage());
            session()->flash('error', 'Произошла ошибка при обработке заказа.');
        }
    }

    private function processRental($isPaid): void
    {
        Log::info('Результат оплаты (isPaid): ', ['isPaid' => $isPaid]);
        try {
            $order = RentalOrder::create([
                'rental_card_id' => $this->order['cardId'],
                'user_id' => Auth::id(),
                'times' => json_encode($this->order['groupedTimes']),
                'status' => $isPaid ? 'Оплачено' : 'Не оплачено',
            ]);

            if ($isPaid) {
                foreach ($this->order['allTimes'] as $time) {
                    $start = $time[0];
                    RentalTime::where('rental_card_id', $this->order['cardId'])
                        ->where('start_time', $start)
                        ->update(['is_booked' => 1]);
                }
            }

            session()->forget('checkout');
            $message = $isPaid ? 'Ваш заказ успешно оплачен!' : 'Оплата не удалась.';
            session()->flash('success', $message);
            redirect()->route('orders');
            return;
        } catch (\Exception $e) {
            Log::error('Ошибка при обработке заказа: ' . $e->getMessage());
            session()->flash('error', 'Произошла ошибка при обработке заказа.');
        }
    }

    private function determineCardType($number): string
    {
        if (preg_match('/^2/', $number)) {
            return 'МИР';
        } elseif (preg_match('/^4/', $number)) {
            return 'VISA';
        } elseif (preg_match('/^5[1-5]/', $number)) {
            return 'MasterCard';
        } elseif (preg_match('/^3[47]/', $number)) {
            return 'American Express';
        } else {
            return 'Неизвестная карта';
        }
    }

    public function updatedCardNumber(): void
    {
        $this->cardType = $this->determineCardType($this->cardNumber);
    }

    private function getSelectedTickets()
    {
        return $this->order['tickets'] ?? [];
    }

    public function render()
    {
        return view('livewire.payment-page', [
            'order' => $this->order,
            'type' => $this->type,
            'selectedTickets' => $this->getSelectedTickets(),
            'cardType' => $this->cardType,
        ])->extends('layouts.main');
    }
}
