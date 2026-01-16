<div  class="mt-2">
    <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <input @if($attributes['read-only']) readonly @endif type="number" {{$attributes->wire('model')}} @if($attributes['max']) max="{{$attributes['max']}}" @endif @if($attributes['min']) min="{{$attributes['min']}}" @endif id="{{$attributes->wire('model')->value}}" class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" placeholder="{{ $attributes['placeholder'] }}">
    @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

