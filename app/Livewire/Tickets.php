<?php

namespace App\Livewire;

use App\Models\Card as CardModel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Tickets extends Component
{
    use WithFileUploads;

    public $cards;
    public $title, $description, $price, $image;

    protected $listeners = ['refreshCards' => 'loadCards'];

    public function mount(): void
    {
        $this->loadCards();
    }


    public function loadCards(): void
    {
        $this->cards = CardModel::all();
    }


    public function saveTicket(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->image ? $this->image->store('cards', 'public') : null;

        CardModel::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->reset(['title', 'description', 'price', 'image']);
        session()->flash('success', 'Билет успешно добавлен!');
        $this->loadCards();
    }
    public function deleteCard($cardId)
    {
        $card = CardModel::find($cardId);

        if (!$card) {
            session()->flash('error', 'Карточка не найдена.');
            return;
        }

        if ($card->image) {
            Storage::disk('public')->delete($card->image);
        }

        $card->delete();
        $this->loadCards();

        session()->flash('success', 'Карточка успешно удалена.');
    }

    public function render()
    {
        return view('livewire.tickets')->layout('layouts.main');
    }
}
