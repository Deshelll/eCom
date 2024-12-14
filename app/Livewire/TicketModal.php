<?php

namespace App\Livewire;

use App\Models\Card;
use App\Models\RentalCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketModal extends Component
{
    use WithFileUploads;
    public bool $isAdmin = false;

    public bool $isOpen = false;
    public bool $isEditMode = false;

    public string $title = '';
    public string $description = '';
    public $image = null;
    public int $price = 0;
    public int $itemId = 0;

    public int $totalTickets = 0;
    public int $availableTickets = 0;
    public string $type = 'ticket';

    protected $listeners = ['openModal'];

    /**
     * Открыть модальное окно
     *
     * @param int $id
     * @param string $type
     */
    public function openModal(int $id, string $type = 'ticket'): void
{
    $this->resetData();
    $this->itemId = $id;
    $this->type = $type;

    $this->isAdmin = auth()->user() && auth()->user()->role_id === 1;


    $item = $this->loadItem($id, $type);

    if ($item) {
        $this->populateItem($item, $type);
        $this->isOpen = true;
        $this->isEditMode = false;
    } else {
        Log::error("Item not found with ID: $id or invalid type: $type");
        $this->isOpen = false;
    }
}

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->reset(['title', 'description', 'image', 'price', 'itemId', 'isEditMode']);
    }


    public function enableEditMode(): void
    {
        $this->isEditMode = true;
    }

    public function saveChanges(): void
    {
        try {
            // Проверяем тип и загружаем соответствующую модель
            if ($this->type === 'ticket') {
                $item = Card::findOrFail($this->itemId);
            } elseif ($this->type === 'rental') {
                $item = RentalCard::findOrFail($this->itemId);
            } else {
                session()->flash('error', 'Неверный тип элемента.');
                return;
            }

            $item->title = $this->title;
            $item->description = $this->description;
            $item->price = $this->price;

            $item->save();
            $this->closeModal();

            $this->emitTo('tickets', 'refreshCards');

            session()->flash('success', 'Изменения успешно сохранены!');
        } catch (\Exception $e) {
            Log::error('Ошибка сохранения изменений: ' . $e->getMessage());
            session()->flash('error', 'Ошибка сохранения изменений.');
        }
    }

    public function goToCheckout(): void
    {
        if (!$this->itemId) {
            Log::error('Item ID not set in goToCheckout.');
            session()->flash('error', 'ID элемента не найден.');
            return;
        }

        if ($this->type === 'rental') {
            redirect()->route('rental.checkout', ['rentalCardId' => $this->itemId]);
        } elseif ($this->type === 'ticket') {
            redirect()->route('checkout', ['cardId' => $this->itemId]);
        }
    }

    public function getSeatInfo()
    {
        if ($this->type === 'ticket') {
            return $this->getTicketSeatInfo();
        } elseif ($this->type === 'rental') {
            return $this->getRentalSeatInfo();
        }

        return collect();
    }

    public function render()
    {
        return view('livewire.ticket-modal');
    }

    private function resetData(): void
    {
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->price = 0;
        $this->totalTickets = 0;
        $this->availableTickets = 0;
    }


    private function loadItem(int $id, string $type)
    {
        if ($type === 'ticket') {
            return Card::with('tickets')->find($id);
        } elseif ($type === 'rental') {
            return RentalCard::with('rentalTimes')->find($id);
        }

        return null;
    }

    private function populateItem($item, string $type): void
{
    $this->title = $item->title ?? '';
    $this->description = $item->description ?? '';
    $this->image = $item->image ?? '';
    $this->price = $item->price ?? 0;

    if ($type === 'ticket') {
        $this->totalTickets = $item->tickets->total_tickets ?? 0;
        $this->availableTickets = $item->tickets->available_tickets ?? 0;
    }
}


    private function getTicketSeatInfo()
    {
        $item = Card::with('tickets')->find($this->itemId);
        if ($item) {
            return $item->tickets->map(function ($ticket) {
                return [
                    'seat_number' => $ticket->seat_number ?? 'Место',
                    'is_booked' => $ticket->is_booked,
                ];
            });
        }

        return collect();
    }

    private function getRentalSeatInfo()
    {
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

        return collect();
    }
}
