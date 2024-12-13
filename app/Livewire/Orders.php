<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\RentalOrder;
use Illuminate\Support\Facades\Log;

class Orders extends Component
{
    public $type = '';
    public $search = '';
    public $ticketCount = null;
    public $orders = [];
    public $rentalOrders = [];

    public function mount()
    {
        $this->filterOrders();
    }

    public function updated($field, $value): void
    {
        if (in_array($field, ['type', 'search', 'ticketCount'])) {
            Log::info("Обновлено поле {$field} с новым значением {$value}");
            $this->filterOrders();
        }
    }

    public function filterOrders(): void
    {
        Log::info('Фильтрация заказов начата', [
            'type' => $this->type,
            'search' => $this->search,
            'ticketCount' => $this->ticketCount,
        ]);

        if ($this->type === 'tickets' || $this->type === '') {
            $this->orders = Order::with(['tickets', 'card'])
                ->where('user_id', auth()->id()) // Фильтрация по текущему пользователю
                ->when($this->search, function ($query) {
                    $query->whereHas('card', function ($q) {
                        $q->where('title', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->ticketCount, function ($query) {
                    $query->where('tickets_count', $this->ticketCount);
                })
                ->get();
        }

        if ($this->type === 'rental' || $this->type === '') {
            $this->rentalOrders = RentalOrder::with('rentalCard')
                ->where('user_id', auth()->id()) // Фильтрация по текущему пользователю
                ->when($this->search, function ($query) {
                    $query->whereHas('rentalCard', function ($q) {
                        $q->where('title', 'like', '%' . $this->search . '%');
                    });
                })
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.orders', [
            'orders' => $this->orders,
            'rentalOrders' => $this->rentalOrders,
        ])->layout('layouts.main');
    }
}
