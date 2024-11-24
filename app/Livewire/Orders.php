<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Order;

class Orders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with(['tickets', 'card'])
            ->where('user_id', Auth::id())
            ->get();
    }


    public function render()
    {
        return view('livewire.orders')->layout('layouts.main');
    }
}
