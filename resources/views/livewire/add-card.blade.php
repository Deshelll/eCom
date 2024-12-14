<div class="p-4 bg-white shadow-md rounded-md">
    <h3 class="text-xl font-semibold mb-4">Добавить новую карточку</h3>

    <form wire:submit.prevent="saveCard">
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Название</label>
            <input type="text" id="title" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-300 focus:border-teal-300">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
            <textarea id="description" wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-300 focus:border-teal-300"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
            <input type="number" id="price" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-300 focus:border-teal-300">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Картинка</label>
            <input type="file" id="image" wire:model="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-300 focus:border-teal-300">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">Добавить</button>
    </form>
</div>
