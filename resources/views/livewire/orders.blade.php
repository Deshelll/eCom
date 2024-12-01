<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Мои заказы</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <p class="text-center text-gray-600">Вы пока не сделали ни одного заказа.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($orders as $order)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">
                        Заказ №{{ $order->id }} - {{ $order->card->title ?? 'Маршрут не указан' }}
                    </h3>
                    <p><strong>Карта:</strong> {{ $order->card_id }}</p>
                    <p><strong>Количество билетов:</strong> {{ $order->tickets_count }}</p>
                    <ul class="mt-2">
                        <strong>Билеты:</strong>
                        @foreach ($order->tickets as $ticket)
                            <li>- {{ $ticket->name }} ({{ $ticket->phone }})</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
