<footer class="border-top bg-body-tertiary py-3 mt-auto">
    <div class="container d-flex flex-column flex-md-row justify-content-between small text-body-secondary">
        <span>&copy; {{ date('Y') }} {{ config('app.name') }} – Web-programozás II beadandó</span>
        <span>
            Készítették:
            @foreach (config('cinema.authors') as $author)
                {{ $author['name'] }} ({{ $author['neptun'] }}){{ ! $loop->last ? ',' : '' }}
            @endforeach
        </span>
    </div>
</footer>
