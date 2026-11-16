<x-layout title="Jelszó megerősítése">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Jelszó megerősítése</h1>
            <p class="text-body-secondary">Ez egy védett terület, kérjük, erősítsd meg a jelszavad.</p>

            <form method="POST" action="{{ route('password.confirm') }}" novalidate>
                @csrf
                <x-field name="password" label="Jelszó" type="password" autocomplete="current-password" />
                <button type="submit" class="btn btn-brand w-100">Megerősítés</button>
            </form>
        </div>
    </div>
</x-layout>
