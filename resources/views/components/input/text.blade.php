<div class="form-group bg_transparent">
    @isset($attributes['label'])
        <label for="{{ $attributes->wire('model')->value }}" class="form-label">{{ $attributes['label'] }}
            @isset($attributes['require'])
                <span class="text-red">(*)</span>
            @endisset
        </label>
    @endisset
    <input @if ($attributes['read-only']) readonly @endif type="text"
        list="{{ $attributes->wire('model')->value }}_list" {{ $attributes->wire('model') }}
        id="text_{{ $attributes->wire('model')->value }}"
        placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Enter Your ' . $attributes['label'] }}"
        class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}">
    @error($attributes->wire('model')->value)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if (isset($attributes['datalist']))
        @if (count($attributes['datalist']) > 0)
            <datalist id="{{ $attributes->wire('model')->value }}_list">
                @foreach ($attributes['datalist'] as $key => $option)
                    <option value="{{ $key }}">{{ $option }}</option>
                @endforeach
            </datalist>
        @endif
    @endif
</div>
