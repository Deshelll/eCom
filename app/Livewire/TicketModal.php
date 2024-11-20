<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class TicketModal extends Component
{
    public bool $isOpen = false;
    public string $title = '';
    public string $description = '';
    public string $image = '';
    public int $price = 0;

    #[On('openModal')]
    public function handleOpenModal(string $title = 'Без названия',
                                    string $description = 'Описание отсутствует',
                                    string $image = '',
                                    int $price = 0): void
    {
        logger('Событие openModal вызвано с данными:', compact('title', 'description', 'image', 'price'));

        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.ticket-modal');
    }
}
