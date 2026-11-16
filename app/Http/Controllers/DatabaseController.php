<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Mozi;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatabaseController extends Controller
{
    public function index(): View
    {
        return view('database', [
            'films' => Film::withCount('mozik')->orderBy('cim')->get(),
            'mozik' => Mozi::withCount('films')->orderBy('nev')->get(),
            'vetitesek' => DB::table('film_mozi')
                ->join('films', 'films.id', '=', 'film_mozi.film_id')
                ->join('mozik', 'mozik.id', '=', 'film_mozi.mozi_id')
                ->select('film_mozi.id', 'films.cim as film', 'mozik.nev as mozi')
                ->orderBy('films.cim')
                ->orderBy('mozik.nev')
                ->get(),
        ]);
    }
}
