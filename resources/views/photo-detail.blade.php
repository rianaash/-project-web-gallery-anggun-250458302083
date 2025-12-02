<x-app-layout>
    <div class="py-6 bg-[#F9F9F9] min-h-screen flex flex-col items-center justify-center p-4 relative">
        
        <div class="absolute top-4 left-4 z-10 md:top-8 md:left-8">
            @php
                // Logika: Cek URL sebelumnya
                $previousUrl = url()->previous();
                $currentUrl = url()->current();
                
                // Kalau URL sebelumnya sama dengan URL sekarang (misal abis refresh), paksa ke Home
                // Kalau URL sebelumnya mengandung '/me', balik ke Profil
                // Sisanya balik ke Home
                if ($previousUrl == $currentUrl) {
                    $backUrl = route('home');
                    $label = "Beranda";
                } elseif (str_contains($previousUrl, '/me')) {
                    $backUrl = route('my.profile');
                    $label = "Profil Saya";
                } else {
                    $backUrl = $previousUrl; // Ikuti history browser
                    $label = "Kembali";
                }
            @endphp

            <a href="{{ $backUrl }}" class="bg-white text-gray-700 px-5 py-2.5 rounded-full font-bold shadow-md hover:bg-[#6DE1D2] hover:text-white transition flex items-center gap-2 group border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                {{ $label }}
            </a>
        </div>

        <div class="bg-white w-full max-w-6xl rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row h-[85vh] md:h-[80vh] border border-gray-100">
            
            <div class="md:w-2/3 bg-black flex items-center justify-center relative group">
                
                <img src="{{ asset('storage/' . $photo->image_url) }}" 
                     class="max-w-full max-h-full object-contain p-2" 
                     alt="{{ $photo->title }}">

                <a href="{{ route('photo.download', $photo->id) }}" 
                   class="absolute bottom-4 right-4 bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-full text-sm font-bold hover:bg-white hover:text-black transition opacity-0 group-hover:opacity-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 12.75l-3-3m0 0l3-3m-3 3h7.5" />
                    </svg>
                    Download
                </a>
            </div>

            <div class="md:w-1/3 bg-white border-l border-gray-200 overflow-hidden h-full">
                
                <livewire:photo-interaction :photoId="$photo->id" />
            
            </div>

        </div>
    </div>
</x-app-layout>