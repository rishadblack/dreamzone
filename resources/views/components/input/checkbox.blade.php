<div class="form-group">
    <label class="custom-control custom-checkbox-md {{ $attributes['class'] }}">
        @php $id = rand(); @endphp
        <input @if ($attributes['read-only']) readonly @endif {{ $attributes->wire('model') }} type="checkbox"
            id="{{ $attributes->wire('model')->value . $id }}" name="{{ $attributes->wire('model')->value }}"
            class="custom-control-input @error($attributes->wire('model')->value) is-invalid @enderror" />
        <span class="custom-control-label"
            for="{{ $attributes->wire('model')->value . $id }}">{{ $attributes['label'] }}</span>
        @error($attributes->wire('model')->value)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </label>
</div>
