<?php

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $judul = '';
    public $isi = '';
    public $tanggal = '';
    public $thumbnail;

    public $posts = [];

    public function mount()
    {
        $this->tanggal = now()->toDateString(); // default today
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $this->posts = Post::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'judul' => 'required|min:3',
            'isi' => 'nullable|string',
            'tanggal' => 'required|date',
            'thumbnail' => 'nullable|image|max:2048', // max 2MB
        ]);

        $path = null;
        if ($this->thumbnail) {
            $path = $this->thumbnail->store('thumbnails', 'public');
        }

        Post::create([
            'judul' => $this->judul,
            'isi' => $this->isi,
            'tanggal' => $this->tanggal,
            'thumbnail' => $path,
        ]);

        $this->reset('judul', 'isi', 'tanggal', 'thumbnail');
        $this->loadArticles();
    }
};
?>

<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Artikel</h1>

    <form wire:submit.prevent="save" class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded shadow">
        <div>
            <label class="block font-semibold dark:text-white">Judul</label>
            <input type="text" wire:model="judul"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" />
            @error('judul')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold dark:text-white">Isi</label>
            <textarea wire:model="isi" type='text' class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white"></textarea>
            @error('isi')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold dark:text-white">Tanggal</label>
            <input type="date" wire:model="tanggal"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" />
            @error('tanggal')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-semibold dark:text-white">Thumbnail</label>
            <input type="file" wire:model="thumbnail" class="w-full dark:text-white" />
            @error('thumbnail')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan Artikel
        </button>
    </form>

    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Daftar Artikel</h2>
        @if (count($posts) > 0)
            <ul class="space-y-4">
                @foreach ($posts as $post)
                    <li class="p-4 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded shadow">
                        @if ($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="Thumbnail"
                                class="mt-2 w-40 rounded">
                        @else
                            <p>tidak ada thumbnail</p>
                        @endif
                        <h3 class="text-lg font-bold">{{ $post->judul }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $post->tanggal->format('d M Y') }}</p>
                        <!-- Menggunakan nl2br untuk menampilkan isi artikel dengan baris baru -->
                        <p class="mt-2 text-sm">{!! nl2br(e($post->isi)) !!}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 dark:text-gray-300">Belum ada artikel.</p>
        @endif
    </div>
</div>
