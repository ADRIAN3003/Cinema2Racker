<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Mozi;
use Illuminate\View\View;

class ChartController extends Controller
{
    public function index(): View
    {
        $films = Film::all();
        $mozik = Mozi::withCount('films')->get();

        $mufajData = $films
            ->countBy(fn ($f) => $f->mufaj ?? 'ismeretlen')
            ->sortDesc();

        $topMozik = $mozik
            ->sortByDesc('films_count')
            ->take(10);

        $szinesData = $films->countBy(fn ($f) => $f->szines ? 'színes' : 'fekete-fehér');

        $szarmazasData = $films
            ->countBy('szarmazas')
            ->sortDesc()
            ->take(8);

        return view('chart', [
            'filmCount' => $films->count(),
            'moziCount' => $mozik->count(),
            'mufajLabels' => $mufajData->keys()->values()->all(),
            'mufajValues' => $mufajData->values()->all(),
            'topMozikLabels' => $topMozik->pluck('nev')->values()->all(),
            'topMozikValues' => $topMozik->pluck('films_count')->values()->all(),
            'szinesLabels' => $szinesData->keys()->values()->all(),
            'szinesValues' => $szinesData->values()->all(),
            'szarmazasLabels' => $szarmazasData->keys()->values()->all(),
            'szarmazasValues' => $szarmazasData->values()->all(),
        ]);
    }
}
