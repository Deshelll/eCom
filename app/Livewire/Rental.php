<?php

namespace App\Livewire;

use App\Models\RentalCard;
use Livewire\Component;
use Livewire\WithFileUploads;

class Rental extends Component
{
    use WithFileUploads;

    public $rentalCards;
    public $title;
    public $description;
    public $price;
    public $image;

    protected $listeners = ['openModal'];

    public function mount(): void
    {
        $this->loadRentalCards();
    }

    public function loadRentalCards(): void
    {
        $this->rentalCards = RentalCard::where('is_available', true)->get();
    }


    public function deleteRentalCard(int $id): void
    {
        $rentalCard = RentalCard::find($id);

        if ($rentalCard) {
            $rentalCard->delete();
            session()->flash('success', 'Карточка аренды успешно удалена!');
        } else {
            session()->flash('error', 'Карточка аренды не найдена.');
        }

        $this->loadRentalCards();
    }

    public function emitOpenModal(int $id): void
    {
        $this->emit('openModal', ['id' => $id, 'type' => 'rental']);
    }

    public function render()
    {
        return view('livewire.rental', [
            'rentalCards' => $this->rentalCards,
        ])->layout('layouts.main');
    }
}