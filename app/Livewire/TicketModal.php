<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class TicketModal extends Component
{
    public bool $isOpen = false;

    public string $title = '';
    public string $description = '';
    public string $image = '';
    public int $price = 0;
    public int $cardId;

    public int $totalTickets = 0;
    public int $availableTickets = 0;

    protected $listeners = ['openModal'];

    #[On('openModal')]
    public function openModal(int $id): void
    {
        Log::info('openModal called with id: ' . $id);
        $card = Card::find($id);

        if ($card) {
            $this->cardId = $id;
            $this->title = $card->title;
            $this->description = $card->description;
            $this->image = $card->image;
            $this->price = $card->price;

            $this->totalTickets = $card->tickets->total_tickets ?? 0;
            $this->availableTickets = $card->tickets->available_tickets ?? 0;

            $this->isOpen = true;
        } else {
            $this->isOpen = false;
        }
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function goToCheckout()
    {
        if (!isset($this->cardId)) {
            session()->flash('error', 'ID карточки не найден.');
            return;
        }

        return redirect()->route('checkout', ['cardId' => $this->cardId]);
    }

    public function render()
    {
        return view('livewire.ticket-modal');
    }
}
