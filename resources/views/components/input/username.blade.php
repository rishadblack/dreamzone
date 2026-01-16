<div class="form-group">
    @isset($attributes['label'])
        <label class="form-label" for="{{ $attributes->wire('model')->value }}">{{ $attributes['label'] }}</label>
    @endisset

    <div
        class="input-group  @if ($attributes[$attributes->wire('model')->value . '_name']) is-valid @endif @error($attributes->wire('model')->value) is-invalid @enderror">
        <input @if ($attributes['read-only']) readonly @endif type="text"
            list="{{ $attributes->wire('model')->value }}_list" {{ $attributes->wire('model') }}
            id="{{ $attributes->wire('model')->value }}"
            class="form-control @if ($attributes[$attributes->wire('model')->value . '_name']) is-valid @endif @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"
            placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Please Type ' . $attributes['label'] }}">
        @if ($attributes[$attributes->wire('model')->value . '_name'])
            <span class="input-group-text">{{ $attributes[$attributes->wire('model')->value . '_name'] }}</span>
        @endif
    </div>
    @error($attributes->wire('model')->value)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
