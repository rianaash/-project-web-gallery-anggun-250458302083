<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
        
        <div class="shrink-0">
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-[#6DE1D2] flex items-center justify-center text-white text-5xl font-bold border-4 border-white shadow-lg">
                {{ substr($user->name, 0, 1) }}
            </div>
        </div>

        <div class="text-center md:text-left flex-1">
            <div class="flex flex-col md:flex-row items-center gap-4 mb-4">
                <h1 class="text-2xl font-light text-gray-800">{{ $user->name }}</h1>
                
                <a href="{{ route('profile') }}" class="px-4 py-1.5 bg-gray-100 text-gray-700 font-bold text-sm rounded-lg hover:bg-gray-200 transition">
                    Edit Profil
                </a>
                
                <a href="{{ route('upload.photo') }}" class="px-4 py-1.5 bg-[#FFD63A] text-gray-800 font-bold text-sm rounded-lg hover:bg-[#ffc906] transition shadow-sm">
                    + Upload Foto
                </a>
            </div>

            <div class="flex justify-center md:justify-start gap-8 mb-4 text-gray-700">
                <div class="text-center md:text-left">
                    <span class="font-bold block text-lg">{{ $myPhotos->count() }}</span>
                    <span class="text-xs text-gray-500">Kiriman</span>
                </div>
                <div class="text-center md:text-left">
                    <span class="font-bold block text-lg">{{ $savedPhotos->count() }}</span>
                    <span class="text-xs text-gray-500">Disimpan</span>
                </div>
            </div>

            <div class="text-sm text-gray-600">
                <p class="font-bold">{{ $user->email }}</p>
                <p>Pecinta hewan sejati. Bergabung sejak {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    <div x-data="{ activeTab: 'posts' }">
        
        <div class="flex justify-center border-t border-gray-200 mb-6">
            <button @click="activeTab = 'posts'" 
                    :class="activeTab === 'posts' ? 'border-t-2 border-gray-800 text-gray-800' : 'text-gray-400 hover:text-gray-600'"
                    class="flex items-center gap-2 px-8 py-4 text-sm font-bold uppercase tracking-widest transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                Postingan
            </button>

            <button @click="activeTab = 'saved'" 
                    :class="activeTab === 'saved' ? 'border-t-2 border-gray-800 text-gray-800' : 'text-gray-400 hover:text-gray-600'"
                    class="flex items-center gap-2 px-8 py-4 text-sm font-bold uppercase tracking-widest transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
                Tersimpan
            </button>
        </div>

        <div x-show="activeTab === 'posts'" class="grid grid-cols-3 gap-1 md:gap-6">
            @forelse($myPhotos as $photo)
                <a href="{{ route('photo.show', $photo->id) }}" class="group relative block bg-gray-100 aspect-square overflow-hidden hover:opacity-90 transition">
                    <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center text-white font-bold gap-4">
                        <span class="flex items-center gap-1">❤️ {{ $photo->likes->count() }}</span>
                        <span class="flex items-center gap-1">💬 {{ $photo->comments->count() }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-400">
                    <div class="text-4xl mb-2">📷</div>
                    <p>Belum ada foto yang diupload.</p>
                    <a href="{{ route('upload.photo') }}" class="text-[#6DE1D2] font-bold text-sm hover:underline">Upload sekarang</a>
                </div>
            @endforelse
        </div>

        <div x-show="activeTab === 'saved'" style="display: none;" class="grid grid-cols-3 gap-1 md:gap-6">
            @forelse($savedPhotos as $photo)
                <a href="{{ route('photo.show', $photo->id) }}" class="group relative block bg-gray-100 aspect-square overflow-hidden hover:opacity-90 transition">
                    <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center text-white font-bold gap-4">
                        <span class="flex items-center gap-1">❤️ {{ $photo->likes->count() }}</span>
                        <span class="flex items-center gap-1">💬 {{ $photo->comments->count() }}</span>
                    </div>
                </a>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-400">
                    <div class="text-4xl mb-2">🔖</div>
                    <p>Belum ada foto yang disimpan.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>