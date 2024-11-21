<div class="container py-6 flex justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-1/2">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
            Оформление заказа: {{ $card->title }}
        </h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-medium text-gray-700">ФИО</label>
                <input type="text" id="full_name" wire:model="full_name" required
                       class="block w-full mt-1 rounded-md border-gray-300 shadow-sm p-2">
                @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="age" class="block text-sm font-medium text-gray-700">Возраст</label>
                <input type="number" id="age" wire:model="age" required min="1"
                       class="block w-full mt-1 rounded-md border-gray-300 shadow-sm p-2">
                @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Номер телефона</label>
                <input type="text" id="phone_number" wire:model="phone_number" required
                       class="block w-full mt-1 rounded-md border-gray-300 shadow-sm p-2">
                @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Количество билетов</label>
                <div class="flex items-center space-x-2">
                    <button type="button"
                            wire:click="decrement"
                            class="px-3 py-1 bg-gray-300 rounded-md hover:bg-gray-400"
                            {{ $tickets_count <= 1 ? 'disabled' : '' }}>-</button>
                    <span class="text-lg">{{ $tickets_count }}</span>
                    <button type="button"
                            wire:click="increment"
                            class="px-3 py-1 bg-gray-300 rounded-md hover:bg-gray-400"
                            {{ $tickets_count >= 10 ? 'disabled' : '' }}>+</button>
                </div>
            </div>

            <div class="mt-6 text-center">
                <button type="submit"
                        class="px-6 py-2 text-white bg-teal-500 rounded-md hover:bg-teal-600">
                    Сделать заказ
                </button>
            </div>
        </form>
    </div>
</div>
