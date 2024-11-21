<div>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($cards as $card)
            @livewire('card-create', ['card' => $card], key($card->id))
        @endforeach
    </div>

    @livewire('ticket-modal')
</div>
