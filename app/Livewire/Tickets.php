<?php

namespace App\Livewire;

use App\Models\Card as CardModel;
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
        // Загружаем все карточки при инициализации компонента
        $this->loadCards();
    }

    /**
     * Загружает список карточек
     *
     * @return void
     */
    public function loadCards(): void
    {
        $this->cards = CardModel::all();
    }

    /**
     * Сохраняет новую карточку
     *
     * @return void
     */
    public function saveTicket(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // Проверка для загрузки изображения
        ]);

        // Загружаем изображение, если оно присутствует
        $imagePath = $this->image ? $this->image->store('cards', 'public') : null;

        CardModel::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imagePath,
        ]);

        $this->reset(['title', 'description', 'price', 'image']);
        session()->flash('success', 'Билет успешно добавлен!');
        $this->loadCards(); // Перезагружаем список карточек
    }

    /**
     * Метод для рендеринга компонента
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.tickets')->layout('layouts.main');
    }
}