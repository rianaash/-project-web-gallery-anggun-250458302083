<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b-4 border-[#6DE1D2] sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center gap-4">
            
            <div class="flex shrink-0 items-center">
                <a href="{{ route('home') }}" wire:navigate class="text-3xl font-extrabold text-[#6DE1D2] flex items-center gap-2 hover:scale-105 transition" style="text-shadow: 1px 1px 0px #eee;">
                    🐾 Whiskr
                </a>
            </div>

            <div class="flex-1 max-w-lg hidden md:block mx-4">
                <form action="/" method="GET" class="relative">
                    <input type="text" name="search" 
                           class="w-full border-2 border-gray-200 rounded-full py-2 pl-5 pr-12 focus:outline-none focus:border-[#6DE1D2] focus:ring-1 focus:ring-[#6DE1D2] transition"
                           placeholder="Cari kucing, anjing...">
                    
                    <button type="submit" class="absolute right-1 top-1 bottom-1 bg-[#F75A5A] hover:bg-[#d64d4d] text-white rounded-full px-4 flex items-center justify-center transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                
                <a href="{{ route('upload.photo') }}" wire:navigate class="bg-[#FFD63A] text-gray-800 px-5 py-2.5 rounded-full font-bold text-sm hover:bg-[#FFA955] hover:text-white transition shadow-md flex items-center gap-2 transform hover:-translate-y-0.5">
                    📸 <span class="hidden lg:inline">Upload</span>
                </a>

                <div class="relative ml-2" x-data="{ open: false }">
                    <button @click="open = ! open" class="w-10 h-10 rounded-full bg-[#6DE1D2] border-2 border-white shadow-md flex items-center justify-center text-white font-bold text-lg hover:ring-2 hover:ring-[#6DE1D2] transition focus:outline-none">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl py-2 ring-1 ring-black ring-opacity-5 z-50 border border-gray-100" 
                         style="display: none;">
                        
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Halo,</p>
                            <p class="font-bold text-[#6DE1D2] truncate">{{ Auth::user()->name }}</p>
                        </div>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-[#F75A5A] font-bold hover:bg-red-50">👑 Admin Panel</a>
                        @endif

                        <a href="{{ route('home') }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#eafffc]">
                            🏠 Beranda
                        </a>

                        <a href="{{ route('my.profile') }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#eafffc]">
                            👤 Akun Saya
                        </a>

                        <button wire:click="logout" class="block w-full text-left px-4 py-2 text-sm text-red-500 font-bold hover:bg-red-50">
                            🚪 Keluar
                        </button>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        
        <div class="p-4 pb-0">
            <form action="/" method="GET" class="relative">
                <input type="text" name="search" class="w-full border-2 border-gray-200 rounded-full py-2 pl-4 pr-10 text-sm" placeholder="Cari hewan...">
                <button type="submit" class="absolute right-1 top-1 bottom-1 bg-[#6DE1D2] text-white rounded-full px-3">🔍</button>
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                🏠 Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('upload.photo')" :active="request()->routeIs('upload.photo')" wire:navigate>
                📸 Upload Foto
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('my.profile')" :active="request()->routeIs('my.profile')" wire:navigate>
                👤 Akun Saya
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        🚪 Keluar
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>