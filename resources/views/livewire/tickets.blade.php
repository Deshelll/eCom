<div>
    <!-- Список существующих карточек -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        @foreach ($cards as $card)
            <div class="relative border rounded p-6 bg-white overflow-hidden">
                @livewire('card-create', ['card' => $card], key($card->id), ['class' => 'shadow-none'])

                <!-- Крестик в квадратике -->
                @if (auth()->check() && auth()->user()->role_id === 1)
                    <button 
                        wire:click="deleteCard({{ $card->id }})" 
                        onclick="return confirm('Вы уверены, что хотите удалить этот билет?')" 
                        class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 flex items-center justify-center rounded hover:bg-red-600 z-10">
                        ✖
                    </button>
                @endif
            </div>
        @endforeach
    </div>

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

    <!-- Форма для добавления нового билета -->
    @if (auth()->check() && auth()->user()->role_id === 1)
        <div class="p-6 bg-white shadow rounded-md">
            <h3 class="text-lg font-semibold mb-4">Добавить новый билет</h3>
            <form wire:submit.prevent="saveTicket">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium">Название</label>
                    <input type="text" id="title" wire:model="title" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium">Описание</label>
                    <textarea id="description" wire:model="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium">Цена</label>
                    <input type="number" id="price" wire:model="price" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium">Картинка</label>
                    <input type="file" id="image" wire:model="image" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">Создать</button>
                </div>
            </form>
        </div>
    @endif

    <!-- Модальное окно -->
    @livewire('ticket-modal')
</div>