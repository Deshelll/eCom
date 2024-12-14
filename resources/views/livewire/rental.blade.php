<div>
    <!-- Список существующих карточек аренды -->
    @if ($rentalCards->isEmpty())
        <p class="text-center text-gray-600">Карточки для аренды отсутствуют.</p>
    @else
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach ($rentalCards as $card)
                <div class="relative bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer"
                     wire:click="$dispatch('openModal', { id: {{ $card->id }}, type: 'rental' })">
                    <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-48 object-cover rounded-t-lg">
                    <h3 class="text-lg font-semibold mt-4">{{ $card->title }}</h3>
                    <p class="text-sm text-gray-600 mt-2">{{ $card->description }}</p>
                    <p class="text-lg font-semibold text-teal-600 mt-4">{{ $card->price }} ₽</p>

                    <!-- Кнопка удаления карточки -->
                    @if (auth()->check() && auth()->user()->role_id === 1)
                        <button 
                            wire:click="deleteRentalCard({{ $card->id }})" 
                            onclick="return confirm('Вы уверены, что хотите удалить эту карточку?')" 
                            class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 flex items-center justify-center rounded hover:bg-red-600 z-10">
                            ✖
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Сообщения об успехе и ошибке -->
    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Модальное окно -->
    @livewire('ticket-modal')
</div>