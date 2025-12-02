<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage; 

class PhotoManager extends Component
{
    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.photo-manager', [
         
            'photos' => Photo::with(['user', 'category'])->latest()->get()
        ]);
    }

    // Fitur Hapus Foto
    public function delete($id)
    {
        $photo = Photo::find($id);

        // 1. Hapus file gambar asli di folder storage
        if ($photo->image_url) {
            Storage::disk('public')->delete($photo->image_url);
        }

        // 2. Hapus data di database
        $photo->delete();

        session()->flash('message', 'Foto berhasil dihapus! 🗑️');
    }
}