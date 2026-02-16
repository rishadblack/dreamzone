@props([
    'label' => null,
    'placeholder' => null,
    'class' => '',
    'readOnly' => false,
])

@php
    $model = $attributes->wire('model')->value;
    $nameValue = $attributes->get($model . '_name');
@endphp

<div class="mb-3">

    @if ($label)
        <label for="{{ $model }}" class="form-label">
            {{ $label }}
        </label>
    @endif

    <div class="input-group">

        <input type="text" id="{{ $model }}" list="{{ $model }}_list" {{ $attributes->wire('model') }}
            @readonly($readOnly)
            class="form-control
                @if ($nameValue) is-valid @endif
                @error($model) is-invalid @enderror
                {{ $class }}"
            placeholder="{{ $placeholder ?? 'Please Type ' . $label }}">

        @if ($nameValue)
            <span class="input-group-text">
                {{ $nameValue }}
            </span>
        @endif

        @error($model)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>
