<div  class="form-group">
    <div class="d-flex justify-content-between">
        <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    </div>
    <div class="input-group input-group-merge form-password-toggle">
        <input  @if($attributes['read-only']) readonly @endif type="password" {{$attributes->wire('model')}} class="form-control form-control-merge @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" placeholder="{{ $attributes['placeholder'] }}" id="{{$attributes->wire('model')->value}}" name="{{$attributes->wire('model')->value}}" aria-describedby="{{$attributes->wire('model')->value}}" placeholder="{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Please Type '.$attributes['label']  }}" />
        {{-- <div class="input-group-append"><span class="cursor-pointer input-group-text">Show</div> --}}
        @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
