<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\Media;
use App\Models\People;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\Facility;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    /**
     * Halaman Utama (Beranda)
     */
    public function index()
    {
        $teacherCount = People::where('role','teacher')->count();
        $studentCount = People::where('role','student')->count();
        $latestArticles = Post::where('type', 'article')
            ->where('is_published', true)
            ->latest()->take(3)->get();

        $latestAnnouncements = Post::where('type', 'announcement')
            ->where('is_published', true)
            ->latest()->take(3)->get();

        $latestAchievements = Achievement::latest('year')
            ->take(3)
            ->get();

        $latestMedia = Media::latest()
            ->take(6)
            ->get();

        $extracurriculars = Extracurricular::orderBy('name', 'asc')
            ->take(4)
            ->get();

        return Inertia::render('Welcome', [
        'teacherCount'=>$teacherCount,
        'studentCount'=>$studentCount,
            'latestArticles' => $latestArticles,
            'latestAnnouncements' => $latestAnnouncements,
            'latestAchievements' => $latestAchievements,
            'latestMedia' => $latestMedia,
            'extracurriculars' => $extracurriculars,
        ]);
    }

    /**
     * Pusat Informasi
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

    public function detailArtikel($slug)
    {
        $article = Post::where('type', 'article')
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $recommendations = Post::where('type', 'article')
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('PusatInformasi/DetailArtikel', [
            'article' => $article,
            'recommendations' => $recommendations,
        ]);
    }

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

    public function detailPengumuman($slug)
    {
        $announcement = Post::where('type', 'announcement')
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $recentAnnouncements = Post::where('type', 'announcement')
            ->where('is_published', true)
            ->where('id', '!=', $announcement->id)
            ->latest()
            ->take(4)
            ->get(['id', 'title', 'slug', 'created_at']);

        return Inertia::render('PusatInformasi/DetailPengumuman', [
            'announcement' => $announcement,
            'recentAnnouncements' => $recentAnnouncements,
        ]);
    }

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
     * Sivitas & Kesiswaan
     */
    public function teacher(Request $request)
    {
        $search = $request->input('search');

        $teachers = People::where('role', ['teacher','staff'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('id_number', 'like', "%{$search}%");
                });
            })
            ->with('classroom')
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Sivitas/DataGuru', [
            'teachers' => $teachers,
            'filters' => $request->only(['search']),
        ]);
    }



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
            'extracurriculars' => $extras,
            'filters' => $request->only(['search']),
        ]);
    }

    public function achievement(Request $request)
    {
        $search = $request->input('search');

        $achievements = Achievement::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('level', 'like', "%{$search}%");
            });
        })
        ->orderBy('year', 'desc')
        ->paginate(12)
        ->withQueryString();

        return Inertia::render('Kesiswaan/Prestasi', [
            'achievements' => $achievements,
            'filters' => $request->only(['search']),
        ]);
    }
    /**
         * Profil & Fasilitas
         */
        public function facility(Request $request)
        {
            $search = $request->input('search');

            $facilities = Facility::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->orderBy('category', 'asc') // Bisa diubah ke 'name' jika ingin urut abjad nama
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->withQueryString();

            return Inertia::render('Kesiswaan/Fasilitas', [ // Sesuaikan path folder Vue Anda
                'facilities' => $facilities,
                'filters' => $request->only(['search']),
            ]);
        }
}
