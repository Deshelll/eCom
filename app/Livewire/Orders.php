<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class Orders extends Component
{
    public $orders;

    public function mount()
    {
        // Получаем оплаченные заказы
        $this->orders = Order::with(['tickets', 'card'])->get();
    }

    public function render()
    {
        return view('livewire.orders')->layout('layouts.main');
    }
}
