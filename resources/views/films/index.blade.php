<x-layout title="Filmek kezelése">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="h3 mb-0">Filmek kezelése</h1>
        <a href="{{ route('films.create') }}" class="btn btn-brand">Új film</a>
    </div>

    <form method="GET" action="{{ route('films.index') }}" class="row g-2 mb-3">
        <div class="col-sm-8 col-md-6">
            <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Keresés cím szerint" aria-label="Keresés cím szerint">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">Keresés</button>
            @if ($search !== '')
                <a href="{{ route('films.index') }}" class="btn btn-link">Törlés</a>
            @endif
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Cím</th>
                        <th>Származás</th>
                        <th>Műfaj</th>
                        <th class="text-end">Hossz</th>
                        <th>Típus</th>
                        <th class="text-end">Mozik</th>
                        <th class="text-end">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($films as $film)
                        <tr>
                            <td>{{ $film->cim }}</td>
                            <td>{{ $film->szarmazas }}</td>
                            <td>{{ $film->mufaj ?? '–' }}</td>
                            <td class="text-end">{{ $film->hossz }} perc</td>
                            <td>
                                <span class="badge text-bg-secondary">{{ $film->szines ? 'színes' : 'fekete-fehér' }}</span>
                                @if ($film->szinkron)
                                    <span class="badge text-bg-dark border">{{ $film->szinkron }}</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $film->mozik_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('films.edit', $film) }}" class="btn btn-sm btn-outline-primary">Szerkesztés</a>
                                <form method="POST" action="{{ route('films.destroy', $film) }}" class="d-inline"
                                      onsubmit="return confirm('Biztosan törlöd ezt a filmet: {{ e($film->cim) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Törlés</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">Nincs a keresésnek megfelelő film.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <span class="text-secondary small">Összesen {{ $films->total() }} film</span>
        {{ $films->links() }}
    </div>
</x-layout>
