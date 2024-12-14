<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
            <div class="bg-white rounded-lg shadow-xl w-[60%] h-[75%] relative flex flex-col overflow-hidden">
                <!-- Заголовок -->
                <div class="modal-header flex justify-between items-center p-4 border-b bg-gray-100">
                    <h5 class="text-xl font-bold text-gray-800">
                        @if ($isEditMode)
                            Редактирование карточки
                        @else
                            {{ $title }}
                        @endif
                    </h5>
                    <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl font-bold transition-all duration-200">&times;</button>
                </div>

                <!-- Тело модального окна -->
                <div class="flex flex-col modal-body p-4 overflow-auto flex-grow">
                    @if ($isEditMode)
                        <!-- Режим редактирования -->
                        <label class="block mb-3">
                            <span class="text-sm font-medium text-gray-700">Название маршрута</span>
                            <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-400">
                        </label>

                        <label class="block mb-3">
                            <span class="text-sm font-medium text-gray-700">Описание</span>
                            <textarea wire:model="description" class="mt-1 block w-full h-28 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-400"></textarea>
                        </label>

                        <label class="block mb-3">
                            <span class="text-sm font-medium text-gray-700">Цена</span>
                            <input type="number" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-teal-400">
                        </label>
                    @else
                        <!-- Режим просмотра -->
                        @if ($image)
                            <div class="rounded-lg overflow-hidden mb-4">
                                <img src="{{ $image }}" alt="Image" class="w-full h-48 object-cover">
                            </div>
                        @endif

                        <p class="text-base text-gray-700 mb-4">{{ $description }}</p>

                        @if($type === 'ticket')
                            <p class="text-gray-600">
                                Билеты: <strong class="text-gray-800">{{ $totalTickets }}</strong> /
                                Доступно: <strong class="text-teal-500">{{ $availableTickets }}</strong>
                            </p>
                        @endif

                        @if($type === 'rental')
                            <div class="mb-4">
                                <h3 class="text-base font-semibold text-gray-800 mb-2">Свободные места</h3>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($this->getSeatInfo() as $seat)
                                        <div class="p-2 border rounded-lg text-center font-medium text-sm
                                            {{ $seat['is_booked'] ? 'bg-gray-200 text-gray-500' : 'bg-green-100 text-green-800' }}">
                                            {{ $seat['seat_number'] ?? $seat['time_slot'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <p class="text-xl font-bold text-teal-600">Цена: {{ $price }} руб.</p>
                    @endif
                </div>

                <!-- Нижняя часть модального окна -->
                <div class="modal-footer flex justify-between items-center p-4 border-t bg-gray-100">
                    @if ($isEditMode)
                        <button type="button" wire:click="saveChanges" class="px-5 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-all">
                            Сохранить
                        </button>
                    @else
                        @if ($isAdmin)
                            <button type="button" wire:click="enableEditMode" class="px-5 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-all">
                                Изменить
                            </button>
                        @endif
                    @endif

                    <button type="button" wire:click.prevent="goToCheckout" class="px-5 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition-all">
                        Купить
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>