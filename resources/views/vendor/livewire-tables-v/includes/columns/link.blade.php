{{-- <a href="{{ $path }}" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>{{ $title }}</a> --}}
<a href="{{ $path }}"
    @isset($attributes['data-id'])
        @php
            $keyname = \Str::of($title)->trim('/');
        @endphp
        wire:key="{{ $keyname . '-' . $attributes['data-id'] }}"
    @endisset
    {{ isset($attributes['data-listener']) ? '' : 'wire:navigate=true' }}
    class="{{ isset($attributes['data-listener']) ? 'callEvent' : '' }} {{ isset($attributes['class']) ? $attributes['class'] : '' }} {{ isset($attributes['data-permission']) ? ucanh($attributes['data-permission']) : '' }}"
    {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>
    @isset($attributes['icon'])
        <i class="{{ $attributes['icon'] }}"></i>
    @endisset
    @isset($attributes['title'])
        {{ $attributes['title'] }}
    @endisset
</a>
