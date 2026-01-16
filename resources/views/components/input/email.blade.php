<div  class="form-group">
    <label class="form-label" for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <div class="form-control-wrap">
        <input @if($attributes['read-only']) readonly @endif type="email" id="{{$attributes->wire('model')->value}}" {{$attributes->wire('model')}} class="form-control @error($attributes->wire('model')->value) invalid @enderror {{ $attributes['class'] }}"  placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Please Type '.$attributes['label']  }}">
            @error($attributes->wire('model')->value) <div class="invalid">{{ $message }}</div> @enderror
    </div>
</div>
