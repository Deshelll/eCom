<div class="container py-6">
    <h1 class="text-2xl font-semibold mb-4 text-center">{{ $rentalCard->title }}</h1>
    <p class="mb-6 text-center text-gray-600">{{ $rentalCard->description }}</p>

    <div class="flex flex-wrap gap-3 justify-center mb-6">
        @foreach ($rentalTimes as $time)
            <button
                wire:click="toggleTimeSelection({{ $time->id }})"
                class="w-16 h-16 flex items-center justify-center border rounded-lg text-sm font-medium shadow-md
                {{ $time->is_booked ? 'bg-gray-600 text-gray-300 cursor-not-allowed' : (in_array($time->id, $selectedTimes) ? 'bg-teal-500 text-white' : 'bg-white hover:bg-gray-100') }}"
                {{ $time->is_booked ? 'disabled' : '' }}>
                {{ \Carbon\Carbon::parse($time->start_time)->format('H:i') }}
            </button>
        @endforeach
    </div>

    <div class="flex justify-center mt-6">
        <button
            wire:click="goToPayment"
            class="px-6 py-2 bg-teal-500 text-white rounded hover:bg-teal-600"
            {{ empty($selectedTimes) ? 'disabled' : '' }}>
            Оплатить
        </button>
    </div>
</div>
