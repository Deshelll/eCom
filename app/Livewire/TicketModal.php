<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\RentalCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TicketModal extends Component
{
    public bool $isOpen = false;

    public string $title = '';
    public string $description = '';
    public string $image = '';
    public int $price = 0;
    public int $itemId;

    public int $totalTickets = 0;
    public int $availableTickets = 0;
    public string $type;

    protected $listeners = ['openModal'];

    public function openModal(int $id, string $type = 'ticket'): void
    {
        $this->itemId = $id;
        $this->type = $type;

        if ($type === 'ticket') {
            $item = Card::find($id);
        } elseif ($type === 'rental') {
            $item = RentalCard::find($id);
        } else {
            Log::error("Invalid type provided to openModal: $type");
            $this->isOpen = false;
            return;
        }

        if ($item) {
            $this->title = $item->title;
            $this->description = $item->description;
            $this->image = $item->image;
            $this->price = $item->price;

            if ($type === 'ticket') {
                $this->totalTickets = $item->tickets->total_tickets ?? 0;
                $this->availableTickets = $item->tickets->available_tickets ?? 0;
            }

            $this->isOpen = true;
        } else {
            Log::error("Item not found with id: $id");
            $this->isOpen = false;
        }
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function goToCheckout()
    {
        if (!isset($this->itemId)) {
            Log::error('Item ID not set in goToCheckout.');
            session()->flash('error', 'ID элемента не найден.');
            return;
        }

        if ($this->type === 'rental') {
            return redirect()->route('rental.checkout', ['rentalCardId' => $this->itemId]);
        } elseif ($this->type === 'ticket') {
            return redirect()->route('checkout', ['cardId' => $this->itemId]);
        }
    }

    public function getSeatInfo()
    {
        if ($this->type === 'ticket') {
            $item = Card::with('tickets')->find($this->itemId);
            if ($item) {
                return $item->tickets->map(function ($ticket) {
                    return [
                        'seat_number' => $ticket->seat_number ?? 'Место',
                        'is_booked' => $ticket->is_booked,
                    ];
                });
            }
        } elseif ($this->type === 'rental') {
            $item = RentalCard::with('rentalTimes')->find($this->itemId);
            if ($item) {
                return $item->rentalTimes->map(function ($time) {
                    $start = Carbon::parse($time->start_time);
                    $end = $start->copy()->addMinutes(45);

                    return [
                        'time_slot' => $start->format('H:i') . ' - ' . $end->format('H:i'),
                        'is_booked' => $time->is_booked,
                    ];
                });
            }
        }
        return collect();
    }

    public function render()
    {
        return view('livewire.ticket-modal');
    }
}
