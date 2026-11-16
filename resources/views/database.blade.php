<x-layout title="Adatbázis">
    <h1 class="h3 mb-1">Adatbázis</h1>
    <p class="text-body-secondary">A moziműsor adatbázis három táblája: filmek, mozik és a vetítések (melyik film melyik moziban megy).</p>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-films" type="button" role="tab">
                Filmek <span class="badge text-bg-secondary">{{ $films->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-mozik" type="button" role="tab">
                Mozik <span class="badge text-bg-secondary">{{ $mozik->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-vetitesek" type="button" role="tab">
                Vetítések <span class="badge text-bg-secondary">{{ $vetitesek->count() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-films" role="tabpanel">
            <div class="table-responsive table-scroll">
                <table class="table table-striped table-sm align-middle">
                    <thead>
                        <tr>
                            <th>#</th><th>Cím</th><th>Műfaj</th><th>Származás</th>
                            <th>Hossz</th><th>Színes</th><th>Szinkron</th><th>Mozik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($films as $film)
                            <tr>
                                <td>{{ $film->id }}</td>
                                <td>{{ $film->cim }}</td>
                                <td>{{ $film->mufaj ?? '–' }}</td>
                                <td>{{ $film->szarmazas }}</td>
                                <td>{{ $film->hossz }} perc</td>
                                <td>{{ $film->szines ? 'igen' : 'fekete-fehér' }}</td>
                                <td>
                                    @switch($film->szinkron)
                                        @case('fel') feliratos @break
                                        @case('mb') magyarul beszélő @break
                                        @default {{ $film->szinkron ?? '–' }}
                                    @endswitch
                                </td>
                                <td>{{ $film->mozik_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-mozik" role="tabpanel">
            <div class="table-responsive table-scroll">
                <table class="table table-striped table-sm align-middle">
                    <thead>
                        <tr><th>#</th><th>Név</th><th>Irányítószám</th><th>Cím</th><th>Telefon</th><th>Filmek</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($mozik as $mozi)
                            <tr>
                                <td>{{ $mozi->id }}</td>
                                <td>{{ $mozi->nev }}</td>
                                <td>{{ $mozi->iranyitoszam }}</td>
                                <td>{{ $mozi->cim }}</td>
                                <td>{{ $mozi->telefon ?? '–' }}</td>
                                <td>{{ $mozi->films_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-vetitesek" role="tabpanel">
            <div class="table-responsive table-scroll">
                <table class="table table-striped table-sm align-middle">
                    <thead><tr><th>#</th><th>Film</th><th>Mozi</th></tr></thead>
                    <tbody>
                        @foreach ($vetitesek as $v)
                            <tr><td>{{ $v->id }}</td><td>{{ $v->film }}</td><td>{{ $v->mozi }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
