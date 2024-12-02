<div class="container py-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Карточки для аренды</h1>

    @if ($rentalCards->isEmpty())
        <p class="text-center text-gray-600">Карточки для аренды отсутствуют.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rentalCards as $card)
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition cursor-pointer"
                     wire:click="$dispatch('openModal', { id: {{ $card->id }}, type: 'rental' })">
                    <img src="{{ $card->image }}" alt="{{ $card->title }}" class="w-full h-48 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-4">{{ $card->title }}</h3>
                    <p class="text-sm text-gray-600 mt-2">{{ $card->description }}</p>
                    <p class="text-lg font-semibold text-teal-600 mt-4">{{ $card->price }} ₽</p>
                </div>
            @endforeach
        </div>
    @endif
    @livewire('ticket-modal')
</div>
