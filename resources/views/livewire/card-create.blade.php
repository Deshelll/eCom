<div class="card border-0 rounded-lg p-4"
     wire:click="$dispatch('openModal', { id: {{ $card->id }}, type: 'ticket' })">
    <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-40 object-cover rounded-t-lg">
    <h3 class="text-xl font-semibold text-gray-800 mt-2">{{ $card['title'] }}</h3>
    <p class="text-sm text-gray-600 mt-1">{{ $card['description'] }}</p>
    <p class="text-lg font-bold text-teal-600 mt-2">{{ $card['price'] }} ₽</p>
</div>