<form method="POST" action="{{ $action }}" novalidate>
    @csrf
    @if ($film->exists)
        @method('PUT')
    @endif

    <x-field name="cim" label="Cím" :value="$film->cim" />

    <div class="row">
        <div class="col-md-6">
            <x-field name="szarmazas" label="Származás" :value="$film->szarmazas" />
        </div>
        <div class="col-md-6">
            <x-field name="mufaj" label="Műfaj" :value="$film->mufaj" :required="false" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-field name="hossz" label="Hossz (perc)" type="number" :value="$film->hossz" />
        </div>
        <div class="col-md-6 mb-3">
            <label for="szinkron" class="form-label">Szinkron</label>
            <select id="szinkron" name="szinkron" class="form-select @error('szinkron') is-invalid @enderror">
                <option value="">Nincs megadva</option>
                @foreach (App\Http\Requests\FilmRequest::SZINKRON as $value => $label)
                    <option value="{{ $value }}" @selected(old('szinkron', $film->szinkron) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('szinkron')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-check form-switch mb-4">
        <input type="hidden" name="szines" value="0">
        <input class="form-check-input" type="checkbox" role="switch" id="szines" name="szines" value="1"
               @checked(old('szines', $film->szines))>
        <label class="form-check-label" for="szines">Színes film</label>
    </div>

    <button type="submit" class="btn btn-brand">{{ $submit }}</button>
    <a href="{{ route('films.index') }}" class="btn btn-outline-secondary">Mégse</a>
</form>
