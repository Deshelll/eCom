<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Card;

class CheckoutForm extends Component
{
    public $cardId;
    public $card;
    public $tickets_count = 1;
    public $full_name;
    public $age;
    public $phone_number;

    public function mount($cardId)
    {
        $this->cardId = $cardId;
        $this->card = Card::find($cardId);

        if (!$this->card) {
            abort(404, 'Карточка не найдена');
        }
    }

    public function increment()
    {
        if ($this->tickets_count < 10) {
            $this->tickets_count++;
        }
    }

    public function decrement()
    {
        if ($this->tickets_count > 1) {
            $this->tickets_count--;
        }
    }

    public function submit()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'phone_number' => 'required|string|max:15',
        ]);

        // Логика сохранения заказа
        session()->flash('message', 'Заказ успешно оформлен!');

        return redirect()->route('home'); // Возвращаем на главную после заказа
    }

    public function render()
    {
        return view('livewire.checkout-form')->layout('layouts.main');
    }
}
