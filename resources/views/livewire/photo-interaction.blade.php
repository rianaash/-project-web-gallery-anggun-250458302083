<div x-data="{ open: false, showReportModal: @entangle('showReportModal') }" class="flex flex-col h-full bg-white relative">

    <div class="p-4 border-b border-gray-100 flex items-center justify-between shrink-0 z-20 bg-white">
        
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#6DE1D2] flex items-center justify-center text-white font-bold shadow-sm text-sm">
                {{ substr($photo->user->name, 0, 1) }}
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm leading-tight">{{ $photo->user->name }}</h4>
                <p class="text-[10px] text-gray-500">{{ $photo->created_at->diffForHumans() }}</p>
            </div>
        </div>git

        <div class="flex items-center gap-2">
            
            <a href="{{ route('photo.download', $photo->id) }}" 
               class="text-gray-400 hover:text-[#6DE1D2] p-2 rounded-full hover:bg-gray-50 transition" 
               title="Download Foto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 12.75l-3-3m0 0l3-3m-3 3h7.5" />
                </svg>
            </a>

            <div class="relative">
                <button @click="open = !open" class="text-gray-400 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                    </svg>
                </button>

                <div x-show="open" 
                     @click.away="open = false" 
                     x-transition.origin.top.right
                     class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-1 overflow-hidden" 
                     style="display: none;">
                    
                    <button @click="showReportModal = true; open = false" class="w-full flex items-center px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition gap-2 text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                        Laporkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('report_success'))
        <div class="mx-4 mt-2 p-3 bg-green-100 text-green-700 text-xs rounded-lg flex items-center gap-2 border border-green-200">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            {{ session('report_success') }}
        </div>
    @endif

    <div class="flex-1 overflow-y-auto p-4 space-y-6 custom-scrollbar">
        
        <div class="flex gap-3">
            <div class="w-8 h-8 rounded-full bg-[#6DE1D2] flex-shrink-0 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                {{ substr($photo->user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="bg-gray-50 p-3 rounded-2xl rounded-tl-none text-sm text-gray-800 leading-relaxed border border-gray-100">
                    <span class="font-bold block text-gray-900 mb-1">{{ $photo->user->name }}</span>
                    {{ $photo->caption }}
                    
                    <div class="mt-3">
                        <span class="text-[10px] font-bold text-[#6DE1D2] bg-white border border-[#6DE1D2]/20 px-2 py-1 rounded-full">
                            #{{ $photo->category->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="border-gray-100">

        @forelse($comments as $comment)
            <div class="flex flex-col gap-2">
                <div class="flex gap-3 group">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center text-xs font-bold text-gray-500">
                        {{ substr($comment->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="bg-white border border-gray-100 p-3 rounded-2xl rounded-tl-none text-sm text-gray-700 shadow-sm">
                            <span class="font-bold block text-gray-900 mb-1">{{ $comment->user->name }}</span>
                            {{ $comment->content }}
                        </div>
                        <div class="flex gap-3 ml-2 mt-1 items-center">
                            <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            <button wire:click="setReply({{ $comment->id }})" class="text-[10px] font-bold text-gray-500 hover:text-[#6DE1D2] transition">Balas</button>
                        </div>
                    </div>
                </div>

                @foreach($comment->replies as $reply)
                    <div class="flex gap-3 pl-12 relative">
                        <div class="absolute left-6 top-0 bottom-6 w-0.5 bg-gray-100"></div>
                        
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-gray-400 z-10">
                            {{ substr($reply->user->name, 0, 1) }}
                        </div>
                        <div class="flex-1 bg-gray-50 p-2 rounded-xl text-xs text-gray-600">
                            <span class="font-bold block text-gray-800">{{ $reply->user->name }}</span> 
                            {{ $reply->content }}
                        </div>
                    </div>
                @endforeach

                @if($replyingTo === $comment->id)
                    <div class="pl-12 mt-2 animate-fade-in-down">
                        <form wire:submit.prevent="submitReply" class="flex gap-2 items-center bg-gray-50 p-2 rounded-lg">
                            <input type="text" wire:model="replyContent" class="flex-1 text-xs border-gray-200 rounded-full bg-white focus:ring-1 focus:ring-[#6DE1D2] focus:border-[#6DE1D2]" placeholder="Tulis balasan...">
                            <button type="submit" class="text-[#6DE1D2] text-xs font-bold px-2">Kirim</button>
                            <button type="button" wire:click="cancelReply" class="text-gray-400 text-xs px-2 hover:text-red-500">Batal</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-300 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 opacity-50">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
                <span class="text-xs">Belum ada komentar. Jadilah yang pertama!</span>
            </div>
        @endforelse
    </div>

    <div class="p-4 border-t border-gray-100 bg-white shrink-0 z-20">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-6">
                <livewire:like-button :photo="$photo" :key="'like-detail-'.$photo->id" />

                <button x-data @click="navigator.clipboard.writeText(window.location.href); alert('Link foto disalin! 🔗')" class="text-gray-400 hover:text-blue-500 transition flex items-center gap-1 group" title="Bagikan">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                    </svg>
                </button>

                <livewire:bookmark-button :photo="$photo" :key="'bookmark-detail-'.$photo->id" />
            </div>
        </div>

        <form wire:submit.prevent="submitComment" class="relative flex items-center">
            <div class="w-8 h-8 rounded-full bg-gray-200 absolute left-2 flex items-center justify-center text-xs font-bold text-gray-600">
                @auth {{ substr(Auth::user()->name, 0, 1) }} @else ? @endauth
            </div>
            <input type="text" wire:model="content" placeholder="Tulis komentar..." class="w-full pl-12 pr-14 py-3 bg-gray-100 border-none rounded-full text-sm focus:ring-2 focus:ring-[#6DE1D2] focus:bg-white transition placeholder-gray-400">
            <button type="submit" class="absolute right-3 text-[#6DE1D2] font-bold text-sm hover:text-teal-600 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                </svg>
            </button>
        </form>
    </div>

    <div x-show="showReportModal" 
         x-transition.opacity
         class="absolute inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm" 
         style="display: none;">
        
        <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-xs text-center transform transition-all" @click.away="showReportModal = false">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            
            <h3 class="font-bold text-gray-800 text-lg mb-1">Laporkan Foto?</h3>
            <p class="text-xs text-gray-500 mb-4">Beritahu kami kenapa foto ini tidak pantas.</p>
            
            <textarea wire:model="reportReason" class="w-full border border-gray-300 rounded-xl p-3 text-sm mb-3 focus:ring-2 focus:ring-red-200 focus:border-red-400 outline-none resize-none" rows="3" placeholder="Alasan (Contoh: Spam, Kekerasan...)"></textarea>
            @error('reportReason') <span class="text-red-500 text-xs block mb-2 text-left ml-1">{{ $message }}</span> @enderror

            <div class="flex flex-col gap-2">
                <button wire:click="submitReport" class="w-full bg-red-500 text-white py-2.5 rounded-xl font-bold text-sm hover:bg-red-600 shadow-md transition active:scale-95">
                    Kirim Laporan
                </button>
                <button @click="showReportModal = false" class="w-full text-gray-500 py-2 text-sm hover:text-gray-700 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>

</div>