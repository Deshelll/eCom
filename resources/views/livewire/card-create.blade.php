<div class="card shadow-lg border-0 rounded-lg p-4" wire:click="emitOpenModal">
    <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-48 object-cover rounded-t-lg">
    <h3 class="text-lg font-bold mt-2">{{ $card['title'] }}</h3>
    <p class="text-sm text-gray-600">{{ $card['description'] }}</p>
    <p class="text-md font-semibold text-teal-500 mt-1">{{ $card['price'] }} руб.</p>
</div>
