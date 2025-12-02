<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Foto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form wire:submit="save">
                        
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Judul</label>
                            <input type="text" wire:model="title" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select wire:model="category_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea wire:model="caption" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">File Foto</label>
                            <input type="file" wire:model="photo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            
                            <div wire:loading wire:target="photo" class="text-sm text-gray-500 mt-1">
                                Loading...
                            </div>
                            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            @if ($photo)
                                <div class="mt-2">
                                    <img src="{{ $photo->temporaryUrl() }}" class="h-32 rounded border border-gray-300">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm font-bold">
                                Simpan
                            </button>
                            
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>