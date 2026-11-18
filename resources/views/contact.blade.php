<x-layout title="Kapcsolat">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">Kapcsolat</h1>
            <p class="text-secondary">Kérdésed vagy észrevételed van a moziműsorral kapcsolatban? Írj nekünk, és megkeressük a válasszal.</p>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('contact.store') }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <x-field name="name" label="Név" :value="auth()->user()?->name" autocomplete="name" />
                            </div>
                            <div class="col-md-6">
                                <x-field name="email" label="E-mail cím" type="email" :value="auth()->user()?->email" autocomplete="email" />
                            </div>
                        </div>

                        <x-field name="subject" label="Tárgy" />

                        <div class="mb-3">
                            <label for="message" class="form-label">Üzenet</label>
                            <textarea id="message" name="message" rows="6" required
                                      class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-brand">Üzenet küldése</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
