<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Photo;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkButton extends Component
{
    public $photo;

    public function mount(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function toggleBookmark()
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        // 2. Cek apakah sudah disimpan?
        $existingBookmark = Bookmark::where('user_id', $userId)
                                    ->where('photo_id', $this->photo->id)
                                    ->first();

        if ($existingBookmark) {
            $existingBookmark->delete(); // Hapus (Un-bookmark)
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'photo_id' => $this->photo->id
            ]); // Simpan (Bookmark)
        }

        // 3. Refresh data foto (relasi bookmarks)
        // Kita tidak perlu refresh seluruh halaman
        unset($this->photo->bookmarks); 
    }

    public function render()
    {
        return view('livewire.bookmark-button');
    }
}