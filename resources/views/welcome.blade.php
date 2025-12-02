<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Whiskr</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .masonry-item {
            break-inside: avoid; /* Mencegah foto terpotong antar kolom */
            margin-bottom: 1.5rem; /* Jarak bawah antar foto */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-figtree antialiased">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 h-16 flex items-center shadow-sm">
        <div class="max-w-7xl w-full mx-auto px-4 flex justify-between items-center gap-4">
            
            <a href="/" class="text-2xl font-extrabold text-[#6DE1D2] hover:opacity-80 transition">
                🐾 Whiskr
            </a>

            <div class="flex-1 max-w-md hidden md:block">
                <form action="/" method="GET" class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full bg-gray-100 border-transparent rounded-full py-2 pl-4 pr-10 text-sm focus:bg-white focus:border-[#6DE1D2] focus:ring-0 transition" 
                           placeholder="Cari foto...">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#6DE1D2]">
                        🔍
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('upload.photo') }}" class="text-sm font-bold text-gray-600 hover:text-[#6DE1D2] px-3 py-2">
                        + Upload
                    </a>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="w-9 h-9 rounded-full bg-[#6DE1D2] text-white font-bold flex items-center justify-center text-sm hover:ring-2 hover:ring-[#6DE1D2] transition">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-500 truncate">Halo, {{ Auth::user()->name }}</div>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-50">Admin Panel</a>
                            @endif
                            <a href="{{ route('my.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Akun Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-[#6DE1D2] px-4 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-[#6DE1D2] text-white px-4 py-2 rounded-full hover:bg-[#5bcbc0]">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="relative bg-[#6DE1D2]/10 border-b border-[#6DE1D2]/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 mb-4 tracking-tight">
                Dunia Hewan <span class="text-[#6DE1D2] drop-shadow-sm">Penuh Warna</span> 🌈
            </h1>
            <p class="text-lg text-gray-500 mb-8 max-w-2xl mx-auto">
                Temukan ribuan foto hewan lucu, bagikan momenmu, dan warnai harimu dengan tingkah gemas mereka.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="/?search=kucing" class="px-5 py-2 bg-white border-2 border-[#FFD63A] text-gray-700 rounded-full text-sm font-bold hover:bg-[#FFD63A] hover:text-white transition">🐱 Kucing</a>
                <a href="/?search=anjing" class="px-5 py-2 bg-white border-2 border-[#FFA955] text-gray-700 rounded-full text-sm font-bold hover:bg-[#FFA955] hover:text-white transition">🐶 Anjing</a>
                <a href="/?search=burung" class="px-5 py-2 bg-white border-2 border-[#F75A5A] text-gray-700 rounded-full text-sm font-bold hover:bg-[#F75A5A] hover:text-white transition">🦜 Burung</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12 min-h-screen">
        
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-[#FFA955] rounded-full"></div>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ request('search') ? 'Hasil: "'.request('search').'"' : 'Foto Terbaru' }}
            </h2>
        </div>

        <div class="columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
            @forelse($photos as $photo)
                
                <div class="masonry-item relative group rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300 bg-gray-100">
                    
                    <a href="{{ route('photo.show', $photo->id) }}" class="block w-full">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" 
                             class="w-full h-auto block" 
                             alt="{{ $photo->title }}">
                        
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300 pointer-events-none"></div>

                        <span class="absolute top-2 left-2 bg-black/40 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition duration-300">
                            {{ $photo->category->name ?? 'Umum' }}
                        </span>
                    </a>

                </div>

            @empty
                <div class="col-span-full text-center py-20 text-gray-400">
                    <p class="text-xl font-bold mb-2">Belum ada foto.</p>
                    @if(request('search'))
                        <a href="/" class="text-sm text-[#6DE1D2] hover:underline">Reset Pencarian</a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 mt-12 py-10 text-center">
        <h3 class="text-xl font-extrabold text-[#6DE1D2] mb-2">🐱 Whiskr</h3>
        <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Made with Love by Anggun.</p>
    </footer>

</body>
</html>