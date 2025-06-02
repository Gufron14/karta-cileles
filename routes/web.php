<?php

use App\Livewire\Home;
use App\Livewire\FormRelawan;
use App\Livewire\Berita\Index;
use Illuminate\Support\Facades\Route;
use App\Livewire\PascaBencana\Bencana;

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

Route::get('/', Home::class)->name('/');

Route::get('berita', Index::class)->name('berita');
Route::get('berita/{slug}', Index::class)->name('viewBerita');

Route::get('donasi', \App\Livewire\Donasi::class)->name('donasi');
Route::get('daftar-relawan', FormRelawan::class)->name('formRelawan');
Route::get('pasca-bencana', Bencana::class)->name('pascaBencana');

Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
Route::get('relawan', \App\Livewire\Admin\Relawan::class)->name('relawan');
Route::get('data-donasi', \App\Livewire\Admin\Donasi::class)->name('data-donasi');
Route::get('pakaian', \App\Livewire\Admin\Pakaian::class)->name('pakaian');
Route::get('makanan', \App\Livewire\Admin\Makanan::class)->name('makanan');