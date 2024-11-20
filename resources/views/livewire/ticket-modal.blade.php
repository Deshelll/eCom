<div>
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-[70%] h-[70%] relative flex flex-col">
                <!-- Заголовок -->
                <div class="modal-header flex justify-between items-center p-4 border-b">
                    <h5 class="text-xl font-bold">{{ $title }}</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl font-bold" wire:click="closeModal">&times;</button>
                </div>

                <!-- Тело модального окна -->
                <div class="modal-body p-4 overflow-auto flex-grow">
                    <p class="text-lg">{{ $description }}</p>
                    @if ($image)
                        <img src="{{ $image }}" alt="Image" class="w-full h-auto rounded mb-4 mt-4">
                    @endif
                    <p class="text-lg font-bold">Цена: {{ $price }} руб.</p>
                </div>

                <!-- Подвал -->
                <div class="modal-footer flex justify-end items-center p-4 border-t">
                    <button type="button" class="px-6 py-3 text-lg rounded bg-gray-300 hover:bg-gray-400 font-semibold mr-2" wire:click="closeModal">Закрыть</button>
                    <button type="button" class="px-6 py-3 text-lg rounded bg-teal-500 hover:bg-teal-600 text-white font-semibold">Купить</button>
                </div>
            </div>
        </div>
    @endif

</div>
