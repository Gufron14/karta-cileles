<?php

use App\Livewire\Bantuan\Donatur;
use App\Livewire\SK;
use App\Livewire\Faq;
use App\Livewire\Home;
use App\Livewire\FormRelawan;
use App\Livewire\Berita\Index;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Auth\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\PascaBencana\Bencana;
use App\Http\Controllers\LogoutController;
use App\Livewire\Bantuan\Makanan;
use App\Livewire\Bantuan\Pakaian;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/db-test', function () {
//     return \DB::select('SELECT NOW()');
// });

Route::get('/check-session', function() {
    session(['test' => 'ok']);
    return session('test');
});



Route::get('/', Home::class)->name('/');

Route::get('berita', Index::class)->name('berita');
Route::get('berita/{slug}', \App\Livewire\Berita\ViewBerita::class)->name('detailBerita');

Route::prefix('bantuan')->group(function(){
    Route::get('donatur', Donatur::class)->name('donatur');
    Route::get('pakaian', Pakaian::class)->name('pakaian');
    Route::get('makanan', Makanan::class)->name('makanan');
});

Route::get('donasi', \App\Livewire\Donasi::class)->name('donasi');
Route::get('daftar-relawan', FormRelawan::class)->name('formRelawan');
Route::get('pasca-bencana', Bencana::class)->name('pascaBencana');

Route::get('faq', Faq::class)->name('faq');
Route::get('syarat-ketentuan', SK::class)->name('sk');


// ADMIN

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
        Route::get('profil', Profile::class)->name('profil');

        Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('kelola-bencana', \App\Livewire\Admin\Bencana\DaftarBencana::class)->name('kelola-bencana');
        Route::get('dokumentasi-bencana', \App\Livewire\Admin\Bencana\DokumentasiBencana::class)->name('dokumentasi-bencana');
        Route::get('relawan', \App\Livewire\Admin\Relawan::class)->name('relawan');
        Route::get('data-donasi', \App\Livewire\Admin\Donasi::class)->name('data-donasi');
        Route::get('data-pakaian', \App\Livewire\Admin\Pakaian\Index::class)->name('data-pakaian');
        Route::get('penyaluran-pakaian', \App\Livewire\Admin\Pakaian\PenyaluranPakaian::class)->name('penyaluran-pakaian');
        Route::get('data-makanan', \App\Livewire\Admin\Makanan\Index::class)->name('data-makanan');
        Route::get('penyaluran-makanan', \App\Livewire\Admin\Makanan\PenyaluranMakanan::class)->name('penyaluran-makanan');
        
        Route::get('kelola-berita', \App\Livewire\Admin\PortalBerita\Index::class)->name('kelola-berita');
        Route::get('tambah-berita', \App\Livewire\Admin\PortalBerita\CreateBerita::class)->name('createBerita');
        Route::get('edit-berita', \App\Livewire\Admin\PortalBerita\UpdateBerita::class)->name('editBerita');
        Route::get('edit-berita/{id}', \App\Livewire\Admin\PortalBerita\UpdateBerita::class)->name('editBeritaId');
    
        // Route untuk upload gambar TinyMCE
        Route::post('upload-image', [\App\Http\Controllers\ImageUploadController::class, 'upload'])->name('upload.image');
    }); 
});

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
});
