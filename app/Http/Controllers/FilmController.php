<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        $films = Film::withCount('mozik')
            ->when($search !== '', fn ($query) => $query->where('cim', 'like', '%'.$search.'%'))
            ->orderBy('cim')
            ->paginate(15)
            ->withQueryString();

        return view('films.index', ['films' => $films, 'search' => $search]);
    }

    public function create(): View
    {
        return view('films.create', ['film' => new Film(['szines' => true])]);
    }

    public function store(FilmRequest $request): RedirectResponse
    {
        $film = Film::create($request->validated());

        return redirect()->route('films.index')->with('status', '„'.$film->cim.'” film létrehozva.');
    }

    public function edit(Film $film): View
    {
        return view('films.edit', ['film' => $film]);
    }

    public function update(FilmRequest $request, Film $film): RedirectResponse
    {
        $film->update($request->validated());

        return redirect()->route('films.index')->with('status', '„'.$film->cim.'” film módosítva.');
    }

    public function destroy(Film $film): RedirectResponse
    {
        $film->delete();

        return redirect()->route('films.index')->with('status', '„'.$film->cim.'” film törölve.');
    }
}
