<div class="form-group">
    <label class="form-label" for="{{ $attributes->wire('model')->value }}">{{ $attributes['label'] }}</label>
    <div class="input-group">
        <input @if ($attributes['read-only']) readonly @endif {{ $attributes->wire('model') }} onFocus="this.select()"
            type="number" id="{{ $attributes->wire('model')->value }}"
            class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"
            placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Please Type ' . $attributes['label'] }}">
        <div class="input-group-append">
            <span class="input-group-text @error($attributes->wire('model')->value) is-invalid @enderror"
                id="basic-addon2">{{ isset($attributes['sign']) ? $attributes['sign'] : currencySymbol() }}</span>
        </div>
        @error($attributes->wire('model')->value)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
