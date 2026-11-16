<x-layout title="Elfelejtett jelszó">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Elfelejtett jelszó</h1>
            <p class="text-body-secondary">Add meg az e-mail címed, és küldünk egy linket az új jelszó beállításához.</p>

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf
                <x-field name="email" label="E-mail cím" type="email" autocomplete="username" />
                <button type="submit" class="btn btn-brand w-100">Link küldése</button>
            </form>

            <div class="mt-3 small"><a href="{{ route('login') }}">Vissza a bejelentkezéshez</a></div>
        </div>
    </div>
</x-layout>
