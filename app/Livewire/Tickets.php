<?php

namespace App\Livewire;

use App\Models\Card as CardModel;
use Livewire\Component;

class Tickets extends Component
{
    public $cards;

    public function mount()
    {
        $this->cards = CardModel::all();
    }

    public function render()
    {
        return view('livewire.tickets')->layout('layouts.main');
    }
}
