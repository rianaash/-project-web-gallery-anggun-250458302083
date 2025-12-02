<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
                🐾 Pet Gallery
            </h2>
            <a href="{{ route('upload.photo') }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2 px-6 rounded-full shadow-md transition transform hover:scale-105 flex items-center gap-2">
                <span>📸</span> Upload Foto Hewan
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-orange-50 min-h-screen"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-teal-400 to-blue-500 rounded-3xl shadow-xl overflow-hidden text-white relative">
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-20"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-white opacity-20"></div>

                <div class="p-8 md:p-12 relative z-10 flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-teal-100 text-lg">Selamat datang di dunia hewan lucu. Yuk bagikan momen peliharaanmu!</p>
                    </div>
                    
                    @if(Auth::user()->role === 'admin')
                        <div class="mt-6 md:mt-0">
                            <a href="{{ route('admin.dashboard') }}" class="bg-white text-teal-600 font-bold py-3 px-6 rounded-xl shadow-lg hover:bg-gray-100 transition flex items-center gap-2">
                                👑 Masuk Panel Admin
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2 px-2">
                <span class="text-2xl">🐶</span>
                <h3 class="text-2xl font-bold text-gray-800">Galeri Terbaru</h3>
            </div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($photos as $photo)
                            <div class="border border-gray-200 rounded-md overflow-hidden shadow-sm hover:shadow-md transition">
                                
                                <a href="{{ route('photo.show', $photo->id) }}">
    
    <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-48 object-cover ...">

</a>
                                
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <a href="{{ route('photo.show', $photo->id) }}" class="font-bold truncate pr-2 hover:text-blue-600">
                                            {{ $photo->title }}
                                        </a>
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                            {{ $photo->category->name ?? '-' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $photo->caption }}</p>
                                    <p class="text-xs text-gray-400">Oleh: {{ $photo->user->name }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-10 text-gray-400">
                                Belum ada foto. Yuk upload sekarang!
                            </div>
                        @endforelse
                    </div>

        </div>
    </div>
</x-app-layout>