<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-[70%] h-[70%] relative flex flex-col">
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold">{{ $title }}</h5>
                    <button type="button" wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                </div>

                <div class="modal-body p-4 overflow-auto flex-grow">
                    <p class="text-lg">{{ $description }}</p>
                    @if ($image)
                        <img src="{{ $image }}" alt="Image" class="w-full h-auto rounded mb-4 mt-4">
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
                </div>

                <div class="modal-footer flex justify-end items-center p-4 border-t">
                    <button type="button"
                            wire:click="closeModal"
                            class="px-6 py-3 text-lg rounded bg-gray-300 hover:bg-gray-400 font-semibold mr-2">Закрыть</button>
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
