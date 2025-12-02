<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Category;
use Illuminate\Support\Str; 

class CategoryManager extends Component
{
    // --- KOTAK PENAMPUNGAN DATA ---
    public $name;          // Kotak buat nampung tulisan nama
    public $category_id;   // Kotak buat nyimpen ID (kalau lagi diedit)
    public $isEditing = false; // Bendera: Lagi mode edit atau enggak?

    // --- INI MANTRA BIAR NEMPEL DI ADMINLTE ---
    #[Layout('layouts.admin')] 
    public function render()
    {
        // Ambil semua kategori dari database, urutkan dari yang terbaru
        return view('livewire.admin.category-manager', [
            'categories' => Category::latest()->get()
        ]);
    }

    // --- JURUS 1: SIMPAN DATA BARU ---
    public function store()
    {
        // Cek dulu: Kotaknya gak boleh kosong & Gak boleh kembar
        $this->validate(['name' => 'required|unique:categories,name']);

        // Perintah ke Database: "Tolong buatkan data baru"
        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name) // Bikin slug otomatis (Kucing Lucu -> kucing-lucu)
        ]);

        // Bersih-bersih: Kosongkan kotak input
        $this->name = ''; 
        
        // Teriak: "Berhasil!"
        session()->flash('message', 'Hore! Kategori baru berhasil dibuat! 🎉');
    }

    // --- JURUS 2: PERSIAPAN EDIT (Ambil Data Dulu) ---
    public function edit($id)
    {
        // Cari data kategori berdasarkan ID
        $cat = Category::find($id);
        
        // Masukkan datanya ke kotak penampungan biar muncul di form
        $this->category_id = $cat->id;
        $this->name = $cat->name;
        
        // Angkat Bendera Edit: "Sekarang kita lagi mode Edit ya!"
        $this->isEditing = true;
    }

    // --- JURUS 3: SIMPAN PERUBAHAN (Update) ---
    public function update()
    {
        // Cek validasi
        $this->validate(['name' => 'required']);

        // Cari datanya lagi
        $cat = Category::find($this->category_id);
        
        // Ubah isinya
        $cat->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name)
        ]);

        // Panggil fungsi Batal biar balik ke mode awal
        $this->cancel();
        
        session()->flash('message', 'Sip! Data berhasil diperbaiki! 👌');
    }

    // --- JURUS 4: HAPUS ---
    public function delete($id)
    {
        // Cari -> Langsung Hapus
        Category::find($id)->delete();
        session()->flash('message', 'Dadah! Kategori sudah dibuang! 👋');
    }

    // --- JURUS 5: BATAL ---
    public function cancel()
    {
        // Kosongkan semua kotak & Turunkan bendera edit
        $this->name = '';
        $this->isEditing = false;
    }
}