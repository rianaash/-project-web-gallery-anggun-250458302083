<x-app-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-[#6DE1D2] border-4 border-white shadow-lg flex items-center justify-center text-white text-4xl font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>

                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-500">{{ Auth::user()->email }}</p>
                    
                    <div class="mt-3 flex items-center justify-center md:justify-start gap-4">
                        <div class="bg-gray-50 px-4 py-1 rounded-lg border border-gray-100">
                            <span class="font-bold text-[#6DE1D2] text-lg">{{ $photos->count() }}</span>
                            <span class="text-xs text-gray-500 uppercase font-bold">Foto Uploaded</span>
                        </div>
                        <a href="{{ route('upload.photo') }}" class="bg-[#FFD63A] hover:bg-[#ffc906] text-gray-800 px-4 py-2 rounded-lg font-bold text-sm shadow-sm transition">
                            + Upload Baru
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="py-12 bg-[#F9F9F9] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-700 flex items-center gap-2">
                    📂 Koleksi Saya
                </h2>
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-[#6DE1D2] font-bold">
                    &larr; Kembali ke Beranda
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($photos as $photo)
                    <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition duration-300">
                        
                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 group-hover:brightness-90">
                            
                            <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-gray-600 text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                {{ $photo->category->name ?? '-' }}
                            </span>
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 truncate mb-1">{{ $photo->title }}</h3>
                            <p class="text-xs text-gray-400 mb-3">{{ $photo->created_at->format('d M Y') }}</p>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('photo.show', $photo->id) }}" class="flex-1 bg-[#6DE1D2] hover:bg-[#5bcbc0] text-white text-center py-2 rounded-lg text-sm font-bold transition">
                                    Lihat
                                </a>
                                <a href="{{ route('photo.download', $photo->id) }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition" title="Download">
                                    ⬇
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-4xl mb-4">
                            📷
                        </div>
                        <h3 class="text-xl font-bold text-gray-600">Belum ada foto nih.</h3>
                        <p class="text-gray-400 mb-6 max-w-md">Mulai bangun portofoliomu dengan mengupload foto hewan kesayangan.</p>
                        <a href="{{ route('upload.photo') }}" class="bg-[#6DE1D2] text-white px-6 py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                            Upload Foto Pertama
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>