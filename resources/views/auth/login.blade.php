<x-layout title="Bejelentkezés">
    <div class="card auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-3">Bejelentkezés</h1>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <x-field name="email" label="E-mail cím" type="email" autocomplete="username" />
                <x-field name="password" label="Jelszó" type="password" autocomplete="current-password" />

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Maradjak bejelentkezve</label>
                </div>

                <button type="submit" class="btn btn-brand w-100">Belépés</button>
            </form>

            <div class="mt-3 small d-flex justify-content-between">
                <a href="{{ route('register') }}">Még nincs fiókom</a>
                @if ($canResetPassword)
                    <a href="{{ route('password.request') }}">Elfelejtett jelszó</a>
                @endif
            </div>
        </div>
    </div>
</x-layout>
