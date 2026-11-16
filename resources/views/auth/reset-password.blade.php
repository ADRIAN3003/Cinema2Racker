<x-layout title="Új jelszó">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Új jelszó beállítása</h1>

            <form method="POST" action="{{ route('password.store') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <x-field name="email" label="E-mail cím" type="email" :value="$email" autocomplete="username" />
                <x-field name="password" label="Új jelszó" type="password" autocomplete="new-password" />
                <x-field name="password_confirmation" label="Jelszó megerősítése" type="password" autocomplete="new-password" />
                <button type="submit" class="btn btn-brand w-100">Jelszó mentése</button>
            </form>
        </div>
    </div>
</x-layout>
