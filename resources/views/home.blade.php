<x-layout title="Főoldal">
    <section class="hero text-center mb-4">
        <h1 class="display-5 fw-bold">🎬 {{ config('app.name') }}</h1>
        <p class="lead mb-4">Moziműsor egy helyen: böngéssz a filmek és a mozik között, nézd meg, hol megy a kedvenc filmed.</p>
        <a href="{{ route('database') }}" class="btn btn-brand btn-lg me-2 mb-2">Műsor böngészése</a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mb-2">Regisztráció</a>
        @else
            <a href="{{ route('chart') }}" class="btn btn-outline-light btn-lg mb-2">Diagramok</a>
        @endguest
    </section>

    <section class="row g-3 mb-4" aria-label="Statisztika">
        <div class="col-6 col-md-3">
            <div class="card stat-card h-100 text-center"><div class="card-body">
                <div class="stat-number">{{ $stats['films'] }}</div>
                <div class="text-secondary">film</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card h-100 text-center"><div class="card-body">
                <div class="stat-number">{{ $stats['mozik'] }}</div>
                <div class="text-secondary">mozi</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card h-100 text-center"><div class="card-body">
                <div class="stat-number">{{ $stats['vetitesek'] }}</div>
                <div class="text-secondary">vetítés</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card h-100 text-center"><div class="card-body">
                <div class="stat-number">{{ $stats['mufajok'] }}</div>
                <div class="text-secondary">műfaj</div>
            </div></div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header fw-semibold">Legtöbb moziban játszott filmek</div>
                <ul class="list-group list-group-flush">
                    @forelse ($topFilms as $film)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $film->cim }}</span>
                            <span class="badge text-bg-secondary">{{ $film->mozik_count }} mozi</span>
                        </li>
                    @empty
                        <li class="list-group-item text-secondary">Még nincs film az adatbázisban.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header fw-semibold">Legtöbb filmet játszó mozik</div>
                <ul class="list-group list-group-flush">
                    @forelse ($topMozik as $mozi)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $mozi->nev }}</span>
                            <span class="badge text-bg-secondary">{{ $mozi->films_count }} film</span>
                        </li>
                    @empty
                        <li class="list-group-item text-secondary">Még nincs mozi az adatbázisban.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('database') }}" class="card feature-card h-100 text-decoration-none"><div class="card-body">
                <h2 class="h5">Adatbázis</h2>
                <p class="mb-0 text-body">A filmek, a mozik és a vetítések teljes listája.</p>
            </div></a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('chart') }}" class="card feature-card h-100 text-decoration-none"><div class="card-body">
                <h2 class="h5">Diagramok</h2>
                <p class="mb-0 text-body">Statisztikák műfajról, származásról és a mozikról.</p>
            </div></a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('contact') }}" class="card feature-card h-100 text-decoration-none"><div class="card-body">
                <h2 class="h5">Kapcsolat</h2>
                <p class="mb-0 text-body">Írj nekünk az űrlapon keresztül.</p>
            </div></a>
        </div>
        <div class="col-md-6 col-lg-3">
            @auth
                <a href="{{ route('messages') }}" class="card feature-card h-100 text-decoration-none"><div class="card-body">
                    <h2 class="h5">Üzenetek</h2>
                    <p class="mb-0 text-body">A beérkezett üzenetek, a legújabbak elöl.</p>
                </div></a>
            @else
                <a href="{{ route('login') }}" class="card feature-card h-100 text-decoration-none"><div class="card-body">
                    <h2 class="h5">Bejelentkezés</h2>
                    <p class="mb-0 text-body">Lépj be, hogy lásd a beérkezett üzeneteket.</p>
                </div></a>
            @endauth
        </div>
    </div>
</x-layout>
