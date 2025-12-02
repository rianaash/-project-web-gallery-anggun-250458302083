<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // HAPUS 'navigate: true'. Biarkan redirect biasa (full reload) agar sesi user terbaca sempurna.
        $this->redirectIntended(default: route('home')); 
    }
}; ?>

<div>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali! 👋</h2>
        <p class="text-gray-500 text-sm">Masuk untuk melihat hewan-hewan lucu.</p>
    </div>

    <form wire:submit="login">
        
        <div>
            <label for="email" class="block font-bold text-sm text-gray-700 ml-2">Email</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#6DE1D2] focus:ring-[#6DE1D2] shadow-sm transition">
            @error('form.email') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block font-bold text-sm text-gray-700 ml-2">Password</label>
            <input wire:model="form.password" id="password" type="password" name="password" required 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#6DE1D2] focus:ring-[#6DE1D2] shadow-sm transition">
            @error('form.password') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="block mt-4 ml-2">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember" 
                    class="rounded border-gray-300 text-[#6DE1D2] shadow-sm focus:ring-[#6DE1D2]">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-400 hover:text-[#F75A5A] rounded-md focus:outline-none transition" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="ms-3 bg-[#6DE1D2] hover:bg-[#5bcbc0] text-white font-bold py-2 px-6 rounded-full shadow-md transition transform hover:scale-105 active:scale-95">
                Masuk 🚀
            </button>
        </div>
    </form>
    
    <div class="mt-6 text-center text-sm">
        Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-[#6DE1D2] hover:underline">Daftar dulu yuk!</a>
    </div>
</div>