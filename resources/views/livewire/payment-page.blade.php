<div class="container py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Оплата заказа</h1>

    <div class="mb-4">
        @foreach ($order['tickets'] as $ticket)
            <p>Билет для {{ $ticket['name'] }} ({{ $ticket['quantity'] }} шт.)</p>
        @endforeach
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Email для получения чека</label>
        <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded">
    </div>

    <button wire:click="processPayment" class="px-4 py-2 bg-teal-500 text-white rounded">
        Оплатить
    </button>
</div>
