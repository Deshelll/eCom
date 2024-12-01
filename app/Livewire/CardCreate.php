<?php

namespace App\Livewire;

use Livewire\Component;

class CardCreate extends Component
{
    public $card;

    public function mount($card)
    {
        $this->card = $card;
    }

    public function emitOpenModal()
    {
        $this->dispatch('openModal', id: $this->card->id);
    }

    public function render()
    {
        return view('livewire.card-create')->layout('layouts.main');
    }
}
