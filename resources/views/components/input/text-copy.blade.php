<div>
    @if ($attributes['label'])
        <label for="{{ $attributes->wire('model')->value }}">{{ $attributes['label'] }}</label>
    @endif
    <div class="input-group">
        <input @if ($attributes['read-only']) readonly @endif {{ $attributes->wire('model') }} type="text"
            id="{{ $attributes->wire('model')->value }}"
            class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"
            placeholder="{{ $attributes['placeholder'] }}">
        <div class="input-group-append">
            <button type="button"
                class="input-group-text input-group-text @error($attributes->wire('model')->value) is-invalid @enderror"
                id="button_{{ $attributes->wire('model')->value }}">Copy</button>
        </div>
        @error($attributes->wire('model')->value)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('js')
    <script>
        var text{{ $attributes->wire('model')->value }} = $("#{{ $attributes->wire('model')->value }}");
        var btn{{ $attributes->wire('model')->value }} = $("#button_{{ $attributes->wire('model')->value }}");

        // copy text on click
        btn{{ $attributes->wire('model')->value }}.on('click', function() {
            text{{ $attributes->wire('model')->value }}.select();
            document.execCommand('copy');
            toastr['success']('', 'Copied to clipboard!');
        });
    </script>
@endpush
