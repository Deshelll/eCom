<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-[80%] h-[90%] relative flex flex-col">
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold">
                        @if ($isEditMode)
                            Редактирование карточки
                        @else
                            Просмотр карточки
                        @endif
                    </h5>
                    <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                </div>

                <div class="flex flex-col modal-body p-4 overflow-auto flex-grow">
                    @if ($isEditMode)
                        <!-- Режим редактирования -->
                        <label class="block mb-2 text-sm font-medium text-gray-700">Название маршрута</label>
                        <input type="text" wire:model="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-300 mb-4">

                        <label class="block mb-2 text-sm font-medium text-gray-700">Описание</label>
                        <textarea wire:model="description" class="w-full h-36 border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-300 mb-4"></textarea>

                        <label class="block mb-2 text-sm font-medium text-gray-700">Цена</label>
                        <input type="number" wire:model="price" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-300 mb-4">
                    @else
                        <!-- Режим просмотра -->
                        <p class="text-lg">{{ $description }}</p>
                        @if ($image)
                            <img src="{{ $image }}" alt="Image" class="w-full h-60 rounded mb-4 mt-4 object-cover">
                        @endif

                        @if($type === 'ticket')
                            <p>
                                Билеты: <strong>{{ $totalTickets }}</strong> /
                                Доступно: <strong>{{ $availableTickets }}</strong>
                            </p>
                        @endif

                        @if($type === 'rental')
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold">Свободные места</h3>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($this->getSeatInfo() as $seat)
                                        <div class="p-2 border rounded-lg text-center
                                            {{ $seat['is_booked'] ? 'bg-gray-300 text-gray-500' : 'bg-green-200 text-green-800' }}">
                                            {{ $seat['seat_number'] ?? $seat['time_slot'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <p class="text-lg font-bold">Цена: {{ $price }} руб.</p>
                    @endif
                </div>

                <div class="modal-footer flex justify-between items-center p-4 border-t">
                    @if ($isEditMode)
                        <!-- Кнопка сохранения изменений -->
                        <button type="button"
                                wire:click="saveChanges"
                                class="px-6 py-3 text-lg rounded bg-teal-500 hover:bg-teal-600 text-white font-semibold">
                            Сохранить
                        </button>
                    @else
                        @if ($isAdmin)
                            <!-- Кнопка для перехода в режим редактирования -->
                            <button type="button"
                                    wire:click="enableEditMode"
                                    class="px-6 py-3 text-lg rounded bg-gray-300 hover:bg-gray-400 font-semibold">
                                Изменить
                            </button>
                        @endif
                    @endif

                    <!-- Кнопка покупки -->
                    <button type="button"
                            wire:click.prevent="goToCheckout"
                            class="px-6 py-3 text-lg rounded bg-teal-500 hover:bg-teal-600 text-white font-semibold">
                        Купить
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>