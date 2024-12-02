<?php

namespace App\Livewire;

use App\Models\RentalCard;
use Livewire\Component;

class Rental extends Component
{
    public $rentalCards;

    protected $listeners = ['openModal'];

    public function mount(): void
    {
        $this->rentalCards = RentalCard::where('is_available', true)->get();
    }

    public function emitOpenModal(int $id): void
    {
        $this->dispatch('openModal', id: $id, type: 'rental');
    }

    public function render()
    {
        return view('livewire.rental', [
            'rentalCards' => $this->rentalCards,
        ])->layout('layouts.main');
    }
}
