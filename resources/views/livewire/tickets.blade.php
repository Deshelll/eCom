<div>
    <!-- Список существующих карточек -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        @foreach ($cards as $card)
            @livewire('card-create', ['card' => $card], key($card->id))
        @endforeach
    </div>

    <!-- Форма для добавления нового билета -->
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

    <!-- Модальное окно -->
    @livewire('ticket-modal')
</div>