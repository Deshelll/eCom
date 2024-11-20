@extends('layouts.main')

@section('title', 'Мои заказы')

@section('content')
    @if($cards->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Мои заказы</h1>
            <p class="text-gray-600">Здесь будет информация о билетах.</p>
        </div>
    @else
        <div class="container py-6">
            <div class="row flex gap-10">
                @foreach($cards as $card)
                    <div class="col-md-4 mb-4 d-flex justify-content-center" style="height: 400px;">
                        <div class="card shadow-lg border-0 rounded-lg"
                             style="width: 18rem; height: 100%; cursor: pointer;"
                             onclick="window.Livewire.dispatch('openModal', {
                                title: '{{ $card->title }}',
                                description: '{{ $card->description }}',
                                image: '{{ $card->image }}',
                                price: {{ $card->price }}
                            })">
                            <img src="{{ $card->image }}" class="card-img-top rounded-top-lg" alt="{{ $card->title }}" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title fw-bold" style="font-weight: bold; padding: 10px;">{{ $card->title }}</h5>
                                <p class="card-text text-muted" style="padding: 10px; flex-grow: 1;">{{ $card->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    @livewire('ticket-modal')
@endsection
