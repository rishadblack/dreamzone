<div class="mt-2">
    @isset($attributes['label'])
        <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    @endisset
    <input @if($attributes['read-only']) readonly @endif type="text" list="{{$attributes->wire('model')->value}}_list" {{$attributes->wire('model')}} id="{{$attributes->wire('model')->value}}" class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Please Type '.$attributes['label']  }}">
    @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div>@enderror
    @isset($attributes['username_name'])
        Account Name : <small class="form-text text-success">{{ $attributes['username_name'] }}</small>
    @endisset
</div>
