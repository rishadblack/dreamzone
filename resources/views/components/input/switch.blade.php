<div class="form-group">
    <label class="custom-switch mb-0">
        @php $id = rand(); @endphp
        <input @if ($attributes['read-only']) readonly @endif {{ $attributes->wire('model') }} type="checkbox"
            id="{{ $attributes->wire('model')->value . $id }}" name="{{ $attributes->wire('model')->value }}"
            class="custom-switch-input @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" />
        <span class="custom-switch-indicator custom-switch-indicator-md"></span>
        <span class="custom-switch-description">{{ $attributes['label'] }}</span>
        @error($attributes->wire('model')->value)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </label>
</div>
