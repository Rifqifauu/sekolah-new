<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\Media;
use App\Models\People;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    /**
     * Halaman Utama (Beranda / Welcome)
     * Tidak dipaginasi karena hanya menampilkan beberapa data terbaru.
     */
    public function index()
    {
        $latestArticles = Post::where('type', 'article')
            ->where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $latestAnnouncements = Post::where('type', 'announcement')
            ->where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        return Inertia::render('Welcome', [
            'latestArticles' => $latestArticles,
            'latestAnnouncements' => $latestAnnouncements,
        ]);
    }

    /**
     * Halaman Daftar Artikel dengan Search & Pagination
     */
    public function article(Request $request)
    {
        $search = $request->input('search');

        $articles = Post::where('type', 'article')
            ->where('is_published', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('PusatInformasi/Artikel', [
            'articles' => $articles,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Halaman Daftar Pengumuman dengan Search & Pagination
     */
    public function announcement(Request $request)
    {
        $search = $request->input('search');

        $announcements = Post::where('type', 'announcement')
            ->where('is_published', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('PusatInformasi/Pengumuman', [
            'announcements' => $announcements,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Halaman Galeri / Media dengan Search & Pagination
     */
    public function media(Request $request)
    {
        $search = $request->input('search');


        $media = Media::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->paginate(12)
        ->withQueryString();


        return Inertia::render('PusatInformasi/Galeri', [
            'media' => $media,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Halaman Daftar Guru dengan Search & Pagination
     */
    public function teacher(Request $request)
    {
        $search = $request->input('search');

        $teachers = People::where('role', 'teacher')
            ->when($search, function ($query, $search) {
                // Diperbarui agar bisa mencari berdasarkan Nama ATAU NIP/NUPTK
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('id_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Sivitas/DataGuru', [
            'teachers' => $teachers,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Halaman Daftar Staf dengan Search & Pagination
     */
    public function staff(Request $request)
    {
        $search = $request->input('search');

        $staff = People::where('role', 'staff')
            ->when($search, function ($query, $search) {
                // Diperbarui agar bisa mencari berdasarkan Nama ATAU NIP/NUPTK
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('id_number', 'like', "%{$search}%");
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Sivitas/DataStaf', [
            'staff' => $staff,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Halaman Ekstrakurikuler dengan Search & Pagination
     */
    public function extra(Request $request)
    {
        $search = $request->input('search');

        $extras = Extracurricular::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->orderBy('name', 'asc')
        ->paginate(12)
        ->withQueryString();

        return Inertia::render('Kesiswaan/Ekstrakurikuler', [
            'extras' => $extras,
            'filters' => $request->only(['search']),
        ]);
    }
}
