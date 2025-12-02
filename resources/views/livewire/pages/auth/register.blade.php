<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        // HAPUS 'navigate: true' di sini juga.
        $this->redirect(route('home', absolute: false));
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Gabung Whiskr! 🐱</h2>
        <p class="text-gray-500 text-sm">Ayo pamerkan hewan kesayanganmu.</p>
    </div>

    <form wire:submit="register">
        
        <div>
            <label for="name" class="block font-bold text-sm text-gray-700 ml-2">Nama Panggilan</label>
            <input wire:model="name" id="name" type="text" name="name" required autofocus 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#FFD63A] focus:ring-[#FFD63A] shadow-sm transition" placeholder="Misal: Si Meong">
            @error('name') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="email" class="block font-bold text-sm text-gray-700 ml-2">Email</label>
            <input wire:model="email" id="email" type="email" name="email" required 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#FFD63A] focus:ring-[#FFD63A] shadow-sm transition">
            @error('email') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="password" class="block font-bold text-sm text-gray-700 ml-2">Password</label>
            <input wire:model="password" id="password" type="password" name="password" required 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#FFD63A] focus:ring-[#FFD63A] shadow-sm transition">
            @error('password') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-bold text-sm text-gray-700 ml-2">Ulangi Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required 
                class="block mt-1 w-full border-gray-200 rounded-full px-4 py-2 focus:border-[#FFD63A] focus:ring-[#FFD63A] shadow-sm transition">
            @error('password_confirmation') <span class="text-red-500 text-sm mt-1 ml-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-400 hover:text-[#6DE1D2] rounded-md transition" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="ms-4 bg-[#FFD63A] hover:bg-[#ffc906] text-gray-800 font-bold py-2 px-6 rounded-full shadow-md transition transform hover:scale-105 active:scale-95">
                Daftar Sekarang ✨
            </button>
        </div>
    </form>
</div>