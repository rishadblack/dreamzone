@props(['options' => []])
@php
    $options = array_merge(
        [
            'dateFormat' => getTimeFormatJS(),
            'enableTime' => false,
            'monthSelectorType' => 'static',
        ],
        $options,
    );
@endphp
<div class="mt-2">
    <label for="{{ $attributes->wire('model')->value }}">{{ $attributes['label'] }}</label>
    <div wire:ignore>
        <input x-data x-init="flatpickr($refs.{{ $attributes->wire('model')->value }}, {{ json_encode((object) $options) }});" {{ $attributes->wire('model') }}
            x-ref="{{ $attributes->wire('model')->value }}" @if ($attributes['read-only']) readonly @endif
            type="text" id="{{ $attributes->wire('model')->value }}"
            class="form-control  @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"
            placeholder="{{ $attributes['placeholder'] }}">
    </div>
    @error($attributes->wire('model')->value)
        <div class="error" style="color:red">{{ $message }}</div>
    @enderror
</div>
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
