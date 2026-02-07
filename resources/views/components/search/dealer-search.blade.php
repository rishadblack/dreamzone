<div class="form-group">
    <label for="{{ $attributes->wire('model')->value }}">{{ $attributes['label'] }}</label>
    <div wire:ignore>
        <select id="{{ $attributes->wire('model')->value }}" name="{{ $attributes->wire('model')->value }}"
            @isset($attributes['multiple']) multiple="multiple" @endisset
            class="form-control {{ $attributes['class'] }}" {{ $attributes->wire('model') }}>
            <option value="">Select {{ $attributes['label'] }}</option>
            @foreach ($dealers as $dealer)
                <option value="{{ $dealer->id }}">{{ $dealer->business_name }}</option>
            @endforeach
        </select>
    </div>
    @error($attributes->wire('model')->value)
        <div class="invalid">{{ $message }}</div>
    @enderror
</div>
@push('css')
    <style>
        .select2-close-mask {
            z-index: 2099;
        }

        .select2-dropdown {
            z-index: 3051;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#{{ $attributes->wire('model')->value }}").select2({
                width: '100%',
                placeholder: "{{ $attributes['placeholder'] }}",
                allowClear: true,
                tags: true,
            }).on("select2:select", function(e) {
                @this.set("{{ $attributes->wire('model')->value }}", $(this).val());
            }).on("select2:unselect", function(e) {
                @this.set("{{ $attributes->wire('model')->value }}", $(this).val());
            }).on("select2:clear", function(e) {
                @this.set("{{ $attributes->wire('model')->value }}", $(this).val());
            });
        });

        window.addEventListener("{{ $attributes->wire('model')->value }}_update", event => {
            var newOption = new Option(event.detail.text, event.detail.id, true, true);
            $("#{{ $attributes->wire('model')->value }}").append(newOption).trigger('change');
            @this.set("{{ $attributes->wire('model')->value }}", $("#{{ $attributes->wire('model')->value }}")
                .val());
        });

        window.addEventListener('select2update', event => {
            $("#{{ $attributes->wire('model')->value }}").val($("#{{ $attributes->wire('model')->value }}").val())
                .trigger('change');
        });
    </script>
@endpush
