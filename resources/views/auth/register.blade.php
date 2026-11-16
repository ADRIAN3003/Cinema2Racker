<x-layout title="Regisztráció">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Regisztráció</h1>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <x-field name="name" label="Név" autocomplete="name" />
                <x-field name="email" label="E-mail cím" type="email" autocomplete="username" />
                <x-field name="password" label="Jelszó" type="password" autocomplete="new-password" />
                <x-field name="password_confirmation" label="Jelszó megerősítése" type="password" autocomplete="new-password" />

                <button type="submit" class="btn btn-brand w-100">Fiók létrehozása</button>
            </form>

            <div class="mt-3 small">
                <a href="{{ route('login') }}">Már van fiókom</a>
            </div>
        </div>
    </div>
</x-layout>
