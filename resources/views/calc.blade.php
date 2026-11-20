<x-layout title="Teszt">
    <h1 class="h3 mb-3">Számológép</h1>

    @if ($error)
        <div class="alert alert-danger" data-testid="error">
            {{ $error }}
        </div>
    @endif

    @if ($result !== null)
        <div class="alert alert-success" data-testid="result">
            {{ $a }} {{ $symbol }} {{ $b }} = {{ $result }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('calc.calculate') }}">
                @csrf

                <div class="mb-3">
                    <label for="a" class="form-label">A szám</label>
                    <input type="number" class="form-control @error('a') is-invalid @enderror" id="a" name="a" value="{{ old('a', $a ?? 0) }}">
                    @error('a')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="b" class="form-label">B szám</label>
                    <input type="number" class="form-control @error('b') is-invalid @enderror" id="b" name="b" value="{{ old('b', $b ?? 0) }}">
                    @error('b')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="op" class="form-label">Művelet</label>
                    <select class="form-select @error('op') is-invalid @enderror" id="op" name="op">
                        <option value="add" {{ old('op', $op ?? 'add') === 'add' ? 'selected' : '' }}>Összeadás (+)</option>
                        <option value="sub" {{ old('op', $op ?? 'add') === 'sub' ? 'selected' : '' }}>Kivonás (-)</option>
                        <option value="mul" {{ old('op', $op ?? 'add') === 'mul' ? 'selected' : '' }}>Szorzás (*)</option>
                        <option value="divide" {{ old('op', $op ?? 'add') === 'divide' ? 'selected' : '' }}>Osztás (/)</option>
                    </select>
                    @error('op')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Számol</button>
            </form>
        </div>
    </div>
</x-layout>
