<?php

namespace App\Livewire;

use App\Models\Card as CardModel;
use Livewire\Component;

class Tickets extends Component
{
    public $cards;

    public function mount(): void
    {
        // Загружаем все карточки при инициализации компонента
        $this->cards = CardModel::all();
    }

    /**
     * Метод для удаления карточки
     *
     * @param int $id
     * @return void
     */

    public function render()
    {
        return view('livewire.tickets')->layout('layouts.main');
    }
}