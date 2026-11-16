{{-- Menu: a vendeg, a regisztralt es az admin mas-mas menupontokat lat.
     Egy menupont csak akkor jelenik meg, ha a route-ja mar letezik (Route::has). --}}
@php
    $items = [
        ['route' => 'home', 'label' => 'Főoldal'],
        ['route' => 'database', 'label' => 'Adatbázis'],
        ['route' => 'contact', 'label' => 'Kapcsolat'],
        ['route' => 'chart', 'label' => 'Diagram'],
    ];
    if (auth()->check()) {
        $items[] = ['route' => 'messages', 'label' => 'Üzenetek'];
    }
    if (auth()->check() && auth()->user()->isAdmin()) {
        $items[] = ['route' => 'films.index', 'label' => 'Filmek kezelése'];
    }
@endphp
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">🎬 {{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu"
                aria-controls="mainMenu" aria-expanded="false" aria-label="Menü">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach ($items as $item)
                    @if (Route::has($item['route']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                               href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item text-body-secondary small me-lg-3">
                        {{ auth()->user()->name }}
                        @if (auth()->user()->isAdmin())
                            <span class="badge text-bg-warning">admin</span>
                        @endif
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">Kijelentkezés</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Bejelentkezés</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Regisztráció</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
