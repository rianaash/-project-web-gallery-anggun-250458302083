<x-app-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center text-3xl">
                    🔖
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">Simpanan Saya</h1>
                    <p class="text-gray-500">Koleksi foto yang kamu tandai sebagai favorit.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-[#F9F9F9] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-[#6DE1D2] font-bold">
                    &larr; Kembali ke Beranda
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($photos as $photo)
                    <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300">
                        <a href="{{ route('photo.show', $photo->id) }}">
                            <div class="relative h-56 overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            </div>
                        </a>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 truncate">{{ $photo->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">Oleh: {{ $photo->user->name }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="text-6xl mb-4 grayscale opacity-50">🔖</div>
                        <h3 class="text-xl font-bold text-gray-400">Belum ada yang disimpan.</h3>
                        <a href="/" class="mt-4 inline-block text-[#6DE1D2] font-bold hover:underline">Jelajah Foto Dulu</a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>