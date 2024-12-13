<?php

namespace App\Livewire;

use App\Models\Card as CardModel;
use Livewire\Component;

class Tickets extends Component
{
    public $cards;

    public function mount(): void
    {
        $this->cards = CardModel::all();
    }

    public function deleteCard($id)
    {
        // Находим карточку
        $card = CardModel::findOrFail($id);

        // Удаляем карточку
        $card->delete();

        // Обновляем список карточек
        $this->cards = CardModel::all();

        // Добавляем уведомление об успешном удалении
        session()->flash('success', 'Карточка успешно удалена!');
    }

    public function render()
    {
        return view('livewire.tickets')->layout('layouts.main');
    }
}
