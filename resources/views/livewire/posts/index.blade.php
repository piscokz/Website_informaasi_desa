<?php

use App\Models\Item;
use Livewire\Volt\Component;

new class extends Component {
    public $items = [];

    public $name = '';
    public $description = '';

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = Item::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string',
        ]);

        Item::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset('name', 'description');

        $this->loadItems(); // refresh data
    }
};
?>

<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Items</h1>

    <!-- Form Tambah Data -->
    <form wire:submit.prevent="save" class="space-y-4 bg-white dark:bg-black p-4 rounded shadow">
        <div>
            <label class="block font-semibold text-gray-800 dark:text-gray-100">Nama</label>
            <input type="text" wire:model="name" class="w-full border border-gray-300 dark:border-gray-700 dark:bg-black dark:text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-800 dark:text-gray-100">Deskripsi</label>
            <textarea wire:model="description" class="w-full border border-gray-300 dark:border-gray-700 dark:bg-black dark:text-white rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-black dark:hover:bg-blue-600 transition border border-gray-700">
            Simpan
        </button>
    </form>

    <!-- Tampilkan Items -->
    @if (count($items) > 0)
        <ul class="space-y-2">
            @foreach ($items as $item)
                <li class="p-2 bg-white dark:bg-black text-gray-900 dark:text-white shadow rounded">
                    <strong>{{ $item->name }}</strong><br>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->description }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 dark:text-gray-400">Belum ada item.</p>
    @endif
</div>