<x-layout title="E-mail megerősítése">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">E-mail cím megerősítése</h1>
            <p>Kérjük, kattints az e-mailben kapott linkre a megerősítéshez.</p>

            @if ($status === 'verification-link-sent')
                <div class="alert alert-success">Új megerősítő linket küldtünk.</div>
            @endif

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-brand">Link újraküldése</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Kijelentkezés</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
