<div>
    <!-- Список существующих карточек аренды -->
    @if ($rentalCards->isEmpty())
        <p class="text-center text-gray-600">Карточки для аренды отсутствуют.</p>
    @else
        <div class="grid grid-cols-3 gap-6 mb-6">
            @foreach ($rentalCards as $card)
                <div class="relative bg-gradient-to-r from-white to-gray-50 shadow-md rounded-lg p-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-xl cursor-pointer"
                     wire:click="$dispatch('openModal', { id: {{ $card->id }}, type: 'rental' })">
                    <!-- Изображение -->
                    <div class="w-full h-48 mb-4 overflow-hidden rounded-lg">
                        <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                    </div>
                    <!-- Название -->
                    <h3 class="text-lg font-semibold text-gray-800">{{ $card->title }}</h3>
                    <!-- Цена -->
                    <p class="text-teal-600 font-bold text-xl mt-2">{{ $card->price }} ₽</p>
                    <!-- Описание -->
                    <p class="text-sm text-gray-600 mt-2">
                        {{ \Illuminate\Support\Str::limit($card->description, 50, '...') }}
                    </p>

                    <!-- Кнопка удаления карточки -->
                    @if (auth()->check() && auth()->user()->role_id === 1)
                        <button 
                            wire:click.stop="deleteRentalCard({{ $card->id }})" 
                            onclick="return confirm('Вы уверены, что хотите удалить эту карточку?')" 
                            class="absolute bottom-2 right-2 bg-red-500 text-white w-10 h-10 flex items-center justify-center rounded-full hover:bg-red-600 transition-all shadow-md">
                            ✖
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Сообщения об успехе и ошибке -->
    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Модальное окно -->
    @livewire('ticket-modal')
</div>