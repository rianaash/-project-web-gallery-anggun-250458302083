<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $photo, $title, $caption, $category_id;
    #[Layout('layouts.app')] 
    public function render()
    {
        return view('livewire.user.upload-photo', [
            'categories' => Category::all()
        ]);
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048',
            'title' => 'required',
            'category_id' => 'required',
        ]);

        $path = $this->photo->store('photos', 'public');

        Photo::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'title' => $this->title,
            'caption' => $this->caption,
            'image_url' => $path,
        ]);

        session()->flash('message', 'Berhasil upload!');
        return redirect()->route('dashboard');
    }
}