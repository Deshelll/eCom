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

    public bool $isOpen = false;
    public bool $isEditMode = false;

    public string $title = '';
    public string $description = '';
    public $image = null; // Позволяет загружать новые изображения
    public int $price = 0;
    public int $itemId = 0;

    public int $totalTickets = 0;
    public int $availableTickets = 0;
    public string $type = 'ticket';

    // Слушатель для событий
    protected $listeners = ['openModal'];

    /**
     * Открыть модальное окно
     *
     * @param int $id
     * @param string $type
     */
    public function openModal(int $id, string $type = 'ticket'): void
    {
        $this->resetData(); // Сброс состояния перед загрузкой новых данных
        $this->itemId = $id;
        $this->type = $type;

        // Загрузка данных для разных типов
        $item = $this->loadItem($id, $type);

        if ($item) {
            // Корректный вызов метода populateItem
            $this->populateItem($item, $type);
            $this->isOpen = true; // Открываем модальное окно
            $this->isEditMode = false; // Режим по умолчанию — просмотр
        } else {
            Log::error("Item not found with ID: $id or invalid type: $type");
            $this->isOpen = false; // Оставляем окно закрытым
        }
    }

    /**
     * Закрыть модальное окно
     */
    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->reset(['title', 'description', 'image', 'price', 'itemId', 'isEditMode']);
    }

    /**
     * Включить режим редактирования
     */
    public function enableEditMode(): void
    {
        $this->isEditMode = true;
    }

    /**
     * Сохранить изменения карточки
     */
    public function saveChanges(): void
    {
        try {
            $card = Card::findOrFail($this->itemId);
            $card->title = $this->title;
            $card->description = $this->description;
            $card->price = $this->price;

            $card->save();

            // Закрываем модальное окно
            $this->closeModal();

            // Обновляем данные в родительском компоненте
            $this->emitTo('tickets', 'refreshCards');

            session()->flash('success', 'Карточка успешно обновлена!');
        } catch (\Exception $e) {
            Log::error('Ошибка сохранения изменений карточки: ' . $e->getMessage());
            session()->flash('error', 'Ошибка сохранения изменений.');
        }
    }

    /**
     * Перейти к оплате
     */
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

    /**
     * Получить информацию о местах
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSeatInfo()
    {
        if ($this->type === 'ticket') {
            return $this->getTicketSeatInfo();
        } elseif ($this->type === 'rental') {
            return $this->getRentalSeatInfo();
        }

        return collect();
    }

    /**
     * Рендеринг компонента
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.ticket-modal');
    }

    /**
     * Сброс состояния перед загрузкой новых данных
     */
    private function resetData(): void
    {
        $this->title = '';
        $this->description = '';
        $this->image = null;
        $this->price = 0;
        $this->totalTickets = 0;
        $this->availableTickets = 0;
    }

    /**
     * Загрузка элемента в зависимости от типа
     *
     * @param int $id
     * @param string $type
     * @return mixed|null
     */
    private function loadItem(int $id, string $type)
    {
        if ($type === 'ticket') {
            return Card::with('tickets')->find($id);
        } elseif ($type === 'rental') {
            return RentalCard::with('rentalTimes')->find($id);
        }

        return null;
    }

    /**
     * Заполнение данных элемента
     *
     * @param mixed $item
     * @param string $type
     */
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

    /**
     * Получить информацию о местах для билетов
     *
     * @return \Illuminate\Support\Collection
     */
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

    /**
     * Получить информацию о временных интервалах для аренды
     *
     * @return \Illuminate\Support\Collection
     */
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