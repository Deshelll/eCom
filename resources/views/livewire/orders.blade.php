<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Мои заказы</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Поля поиска -->
    <div class="mb-6 flex flex-col md:flex-row items-center gap-4">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Поиск по названию"
            class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">

        <input
            type="number"
            wire:model.live="ticketCount"
            placeholder="Количество билетов"
            class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500">
    </div>

    @if ($orders->isEmpty() && $rentalOrders->isEmpty())
        <p class="text-center text-gray-500">Вы пока не сделали ни одного заказа.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Билеты --}}
            @foreach ($orders as $order)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all relative">
                    <div class="absolute bottom-4 right-4 px-3 py-1 text-xs font-bold rounded-lg {{ $order->tickets->every(fn($ticket) => $ticket->status === 'Оплачено') ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ $order->tickets->every(fn($ticket) => $ticket->status === 'Оплачено') ? 'Оплачено' : 'Не оплачено' }}
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Заказ №{{ $order->id }} - {{ $order->card->title ?? 'Маршрут не указан' }}
                    </h3>
                    <p class="text-sm text-gray-600"><strong>Количество билетов:</strong> {{ $order->tickets_count }}</p>
                    <ul class="mt-2 text-sm">
                        <strong>Билеты:</strong>
                        @foreach ($order->tickets as $ticket)
                            <li>- {{ $ticket->name }} ({{ $ticket->phone }})</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- Аренда --}}
            @foreach ($rentalOrders as $rentalOrder)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all relative">
                    <div class="absolute bottom-4 right-4 px-3 py-1 text-xs font-bold rounded-lg {{ $rentalOrder->status === 'Оплачено' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ $rentalOrder->status }}
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Аренда №{{ $rentalOrder->id }} - {{ $rentalOrder->rentalCard->title ?? 'Карта не указана' }}
                    </h3>
                    <p class="text-sm text-gray-600"><strong>Карта:</strong> {{ $rentalOrder->rental_card_id }}</p>
                    <p class="text-sm text-gray-600"><strong>Выбранное время:</strong></p>
                    <ul class="mt-2 text-sm">
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