@props(['name', 'label', 'type' => 'text', 'value' => null, 'autocomplete' => null, 'required' => true])
<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
           @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
           @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
           @required($required)
           class="form-control @error($name) is-invalid @enderror">
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
