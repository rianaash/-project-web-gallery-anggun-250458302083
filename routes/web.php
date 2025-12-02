<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// --- IMPORT MODELS ---
use App\Models\Photo;
use App\Models\User;
use App\Models\Like;

// --- IMPORT LIVEWIRE COMPONENTS ---
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\PhotoManager;
use App\Livewire\User\UploadPhoto;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN DEPAN (LANDING PAGE + PENCARIAN)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $query = Photo::with('user', 'category')->latest();

    if (request('search')) {
        $cari = request('search');
        $query->where(function($q) use ($cari) {
            $q->where('title', 'like', '%' . $cari . '%')
              ->orWhere('caption', 'like', '%' . $cari . '%');
        });
    }

    $photos = $query->get();
    return view('welcome', ['photos' => $photos]);
})->name('home');


/*
|--------------------------------------------------------------------------
| 2. AREA USER (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard: Redirect ke Home
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // Upload Foto (Livewire)
    Route::get('/upload', UploadPhoto::class)->name('upload.photo');

    // Detail Foto
    Route::get('/photo/{id}', function ($id) {
        $photo = Photo::with('user', 'category')->findOrFail($id);
        return view('photo-detail', ['photo' => $photo]);
    })->name('photo.show');

    // Halaman Profil Ala Instagram (User Profile Component)
    Route::get('/me', \App\Livewire\UserProfile::class)->name('my.profile');

    // Download Foto
    Route::get('/download/{id}', function ($id) {
        $photo = Photo::findOrFail($id);
        return Storage::disk('public')->download($photo->image_url);
    })->name('photo.download');

    // Profil Bawaan Breeze (Edit Data Diri)
    Route::view('profile', 'profile')->name('profile');

    // Fitur Like Manual (Buat Halaman Depan)
    Route::post('/toggle-like/{id}', function ($id) {
        $userId = Auth::id();
        $photo = Photo::findOrFail($id);

        $existingLike = Like::where('user_id', $userId)
                            ->where('photo_id', $photo->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => $userId,
                'photo_id' => $photo->id
            ]);
        }

        return back();
    })->name('like.toggle');
});


/*
|--------------------------------------------------------------------------
| 3. AREA ADMIN (Harus Login + Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    
    // Manajemen Kategori
    Route::get('/categories', CategoryManager::class)->name('categories');
    
    // Manajemen Foto
    Route::get('/photos', PhotoManager::class)->name('photos');
    
    // Manajemen Laporan (Reports)
    Route::get('/reports', \App\Livewire\Admin\ReportManager::class)->name('reports');
    
    // Manajemen User (Tabel Biasa)
    // HAPUS TANDA TITIK TIGA (...) DAN GANTI DENGAN INI:
    Route::get('/users', function() {
        $users = User::latest()->get();
        return view('admin.users', ['users' => $users]);
    })->name('users');

});


/*
|--------------------------------------------------------------------------
| 4. AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';