<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Photo;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeButton extends Component
{
    public $photo; // Menyimpan data foto

    public function mount(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        
        // Cek like
        $existingLike = Like::where('user_id', $userId)
                            ->where('photo_id', $this->photo->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $userId,
                'photo_id' => $this->photo->id
            ]);
        }

        // Refresh data foto spesifik ini aja (bukan se-halaman)
        // Kita reload relasi likes-nya biar angkanya update
        $this->photo->load('likes'); 
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}