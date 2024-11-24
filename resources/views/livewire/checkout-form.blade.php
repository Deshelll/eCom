<div class="container py-6 flex flex-col items-center">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Оформление билетов</h1>

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Сетка карточек -->
    <div class="grid grid-cols-3 gap-4 w-full max-w-6xl">
        @foreach ($tickets as $index => $ticket)
            <div class="card shadow-lg border-0 rounded-lg p-4 bg-white relative">
                <button type="button"
                        wire:click="removeTicket({{ $index }})"
                        class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                    &times;
                </button>
                <h3 class="text-lg font-semibold mb-2">Билет {{ $index + 1 }}</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Имя</label>
                    <input type="text"
                           wire:model="tickets.{{ $index }}.name"
                           class="w-full px-3 py-2 border rounded"
                           placeholder="Введите имя">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email"
                           wire:model="tickets.{{ $index }}.email"
                           class="w-full px-3 py-2 border rounded"
                           placeholder="Введите email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input type="text"
                           wire:model="tickets.{{ $index }}.phone"
                           class="w-full px-3 py-2 border rounded"
                           placeholder="Введите телефон">
                </div>
            </div>
        @endforeach

    </div>

    <!-- Управление карточками -->
    <div class="flex items-center space-x-2 mt-6">
        <button type="button" wire:click="addTicket" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            + Добавить билет
        </button>
    </div>

    <!-- Кнопка "Купить" -->
    <div class="mt-6">
        <button type="button" wire:click="submit" class="px-6 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">
            Купить
        </button>
    </div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>
