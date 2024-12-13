<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Мои заказы</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex items-center gap-4">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Название"
            class="w-1/3 px-4 py-2 border rounded-lg">

        <input
            type="number"
            wire:model.live="ticketCount"
            placeholder="Количество билетов"
            class="w-1/3 px-4 py-2 border rounded-lg">
    </div>

@if ($orders->isEmpty() && $rentalOrders->isEmpty())
        <p class="text-center text-gray-600">Вы пока не сделали ни одного заказа.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- билеты --}}
            @foreach ($orders as $order)
                <div class="bg-white p-4 rounded-lg shadow relative">
                    <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                        Оплачено
                    </div>
                    <h3 class="text-lg font-semibold mb-2">
                        Заказ №{{ $order->id }} - {{ $order->card->title ?? 'Маршрут не указан' }}
                    </h3>

                    <p><strong>Количество билетов:</strong> {{ $order->tickets_count }}</p>
                    <ul class="mt-2">
                        <strong>Билеты:</strong>
                        @foreach ($order->tickets as $ticket)
                            <li>- {{ $ticket->name }} ({{ $ticket->phone }})</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- аренда --}}
            @foreach ($rentalOrders as $rentalOrder)
                <div class="bg-white p-4 rounded-lg shadow relative">
                    <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                        Оплачено
                    </div>
                    <h3 class="text-lg font-semibold mb-2">
                        Аренда №{{ $rentalOrder->id }} - {{ $rentalOrder->rentalCard->title ?? 'Карта не указана' }}
                    </h3>
                    <p><strong>Карта:</strong> {{ $rentalOrder->rental_card_id }}</p>
                    <p><strong>Выбранное время:</strong></p>
                    <ul>
                        @if ($rentalOrder->times && is_array(json_decode($rentalOrder->times, true)))
                            @foreach (json_decode($rentalOrder->times, true) as $time)
                                <li>{{ $time[0] }} - {{ $time[1] }}</li>
                            @endforeach
                        @else
                            <li>Время не указано</li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
