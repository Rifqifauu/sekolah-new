<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE DINAMIS (Menggunakan Controller)
// ==========================================
// Beranda diarahkan ke controller karena kita menampilkan artikel & pengumuman terbaru
Route::get('/', [SiteController::class, 'index'])->name('home');

// Kepegawaian (Sivitas)
Route::get('/sivitas/data-guru', [SiteController::class, 'teacher'])->name('teacher.index');
Route::get('/sivitas/data-staf', [SiteController::class, 'staff'])->name('staff.index');

// Kesiswaan (Ekstrakurikuler diambil dari database)
Route::get('/kesiswaan/ekstrakurikuler', [SiteController::class, 'extra'])->name('extra.index');

// Pusat Informasi
Route::get('/pengumuman', [SiteController::class, 'announcement'])->name('announcement.index');
Route::get('/artikel', [SiteController::class, 'article'])->name('article.index');
Route::get('/galeri', [SiteController::class, 'media'])->name('media.index');
Route::get('/pengumuman/{slug}', [SiteController::class, 'detailPengumuman'])->name('announcement.show');
Route::get('/artikel/{slug}', [SiteController::class, 'detailArtikel'])->name('article.show');

// ==========================================
// 2. RUTE STATIS (Langsung Render Inertia)
// ==========================================
// Profil / Tentang Kami
Route::inertia('/profil/sejarah', 'Profil/Sejarah')->name('profil.sejarah');
Route::inertia('/profil/visi-misi', 'Profil/VisiMisi')->name('profil.visi-misi');

// --- UBAH BAGIAN INI ---
// Sebelumnya menggunakan Route::inertia, sekarang gunakan Route::get ke SiteController
Route::get('/kesiswaan/prestasi', [SiteController::class, 'achievement'])->name('prestasi.index');
Route::get('/kesiswaan/fasilitas', [SiteController::class, 'fasilitas'])->name('fasilitas.index');
// -----------------------

// Halaman Kontak
Route::inertia('/contact', 'Contact')->name('contact.index');
