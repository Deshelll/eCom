<div>
    <div class="grid grid-cols-3 gap-4">
        @foreach ($cards as $card)
            <div class="card border rounded shadow-lg p-4 relative" id="card-{{ $card->id }}">
                <!-- Контент карточки -->
                <h3 class="text-lg font-bold">{{ $card->title }}</h3>
                <p class="text-gray-600">{{ $card->description }}</p>
                @if ($card->image)
                    <img src="{{ $card->image }}" alt="Card Image" class="w-full h-32 object-cover mt-2">
                @endif
                <p class="text-green-500 font-semibold mt-2">{{ $card->price }}</p>

                <!-- Кнопка удаления -->
                <button data-id="{{ $card->id }}" class="delete-button absolute top-2 right-2 text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endforeach
    </div>

    <!-- Вывод уведомлений -->
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Модальное окно -->
    @livewire('ticket-modal')
</div>

<!-- Добавляем скрипт для AJAX -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                const cardId = this.getAttribute('data-id');

                if (confirm('Вы уверены, что хотите удалить эту карточку?')) {
                    fetch(`/cards/${cardId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            document.getElementById(`card-${cardId}`).remove();
                            alert('Карточка успешно удалена!');
                        } else {
                            alert('Ошибка при удалении карточки.');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        alert('Произошла ошибка при удалении карточки.');
                    });
                }
            });
        });
    });
</script>