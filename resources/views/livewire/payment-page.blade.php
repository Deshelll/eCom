<div class="container py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">
        {{ $type === 'rental' ? 'Оплата аренды' : 'Оплата заказа' }}
    </h1>

    <div class="mb-4">
        @if($type === 'rental')
            @if (!empty($order['groupedTimes']))
                <p>Выбранное время:</p>
                <ul>
                    @foreach ($order['groupedTimes'] as [$start, $end])
                        <li>{{ $start }} - {{ $end }}</li>
                    @endforeach
                </ul>
            @else
                <p>Вы не выбрали время.</p>
            @endif
        @endif
            @if (!empty($selectedTickets))
                <ul>
                    @foreach ($selectedTickets as $ticket)
                        <li>
                            {{ $ticket['name'] ?? 'Без имени' }} -
                            {{ $ticket['email'] ?? 'Email не указан' }} -
                            {{ $ticket['quantity'] ?? null }} шт.
                        </li>
                    @endforeach
                </ul>
            @else
                <p></p>
            @endif

    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Email для получения чека</label>
        <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded">
        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Номер карты</label>
        <input type="text" wire:model.live="cardNumber"
               class="w-full px-3 py-2 border rounded"
               placeholder="Введите номер карты"
               maxlength="16">
        @if ($cardType)
            <p class="text-sm text-gray-600 mt-2">Тип карты: {{ $cardType }}</p>
        @else
            <p class="text-sm text-gray-600 mt-2">Введите номер карты для определения типа</p>
        @endif
    </div>

    <div>
        <p class="text-lg">Сумма заказа: <strong>{{ number_format($order['totalPrice'], 2, '.', ' ') }} ₽</strong></p>
    </div>

    <button wire:click="processPayment" class="px-4 py-2 bg-teal-500 text-white rounded" @if (!$cardNumber) disabled @endif>
        Оплатить
    </button>
</div>
