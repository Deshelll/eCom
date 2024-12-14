<div>
    <!-- Список существующих карточек -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        @foreach ($cards as $card)
            <div class="relative bg-gradient-to-r from-white to-gray-50 shadow-md rounded-lg p-4 transform transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                <!-- Карточка -->
                @livewire('card-create', ['card' => $card], key($card->id))

                <!-- Кнопка удаления (только для админа) -->
                @if (auth()->check() && auth()->user()->role_id === 1)
                    <button
                        wire:click.stop="deleteCard({{ $card->id }})"
                        onclick="return confirm('Вы уверены, что хотите удалить этот билет?')"
                        class="absolute bottom-2 right-2 bg-red-500 text-white w-10 h-10 flex items-center justify-center rounded-full hover:bg-red-600 transition-all z-10 shadow-md">
                        ✖
                    </button>
                @endif
            </div>
        @endforeach
    </div>


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

    @if (auth()->check() && auth()->user()->role_id === 1)
        <div class="p-8 bg-gradient-to-r from-gray-50 to-white shadow-lg rounded-lg">
            <h3 class="text-xl font-semibold mb-6 text-gray-800">Добавить новый билет</h3>
            <form wire:submit.prevent="saveTicket" class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Название</label>
                    <input
                        type="text"
                        id="title"
                        wire:model="title"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                    <textarea
                        id="description"
                        wire:model="description"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                        <input
                            type="number"
                            id="price"
                            wire:model="price"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Картинка</label>
                        <input
                            type="file"
                            id="image"
                            wire:model="image"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-teal-500 text-white text-sm font-medium rounded-md shadow hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        Создать
                    </button>
                </div>
            </form>
        </div>
    @endif

    @livewire('ticket-modal')
</div>
