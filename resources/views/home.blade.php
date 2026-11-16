<x-layout title="Főoldal">
    <section class="hero text-center mb-4">
        <h1 class="display-5 fw-bold">🎬 {{ config('app.name') }}</h1>
        <p class="lead mb-4">Moziműsor egy helyen: böngéssz a filmek és a mozik között, nézd meg, hol megy a kedvenc filmed.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-brand btn-lg me-2">Regisztráció</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Bejelentkezés</a>
        @endguest
    </section>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h2 class="h5">Filmek és mozik</h2>
                <p class="mb-0">A moziműsor adatbázis három táblája: filmek, mozik és a vetítések (melyik film melyik moziban megy).</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h2 class="h5">Diagramok</h2>
                <p class="mb-0">Statisztikák a filmekről Chart.js diagramokon: műfaj, származás és a vetítések száma.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card h-100"><div class="card-body">
                <h2 class="h5">Kapcsolat</h2>
                <p class="mb-0">Írj nekünk az űrlapon keresztül; a bejelentkezett felhasználók látják a beérkezett üzeneteket.</p>
            </div></div>
        </div>
    </div>
</x-layout>
