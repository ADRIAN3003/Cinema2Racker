<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Mozi;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'stats' => [
                'films' => Film::count(),
                'mozik' => Mozi::count(),
                'vetitesek' => DB::table('film_mozi')->count(),
                'mufajok' => Film::whereNotNull('mufaj')->distinct()->count('mufaj'),
            ],
            'topFilms' => Film::withCount('mozik')
                ->orderByDesc('mozik_count')
                ->orderBy('cim')
                ->take(5)
                ->get(),
            'topMozik' => Mozi::withCount('films')
                ->orderByDesc('films_count')
                ->orderBy('nev')
                ->take(5)
                ->get(),
        ]);
    }
}
