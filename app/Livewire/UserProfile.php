<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] 
class UserProfile extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Ambil foto yang diupload user
        $myPhotos = Photo::where('user_id', $user->id)->latest()->get();

        // Ambil foto yang dibookmark user
        $savedPhotos = Photo::whereHas('bookmarks', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        return view('livewire.user-profile', [
            'user' => $user,
            'myPhotos' => $myPhotos,
            'savedPhotos' => $savedPhotos
        ]);
    }
}