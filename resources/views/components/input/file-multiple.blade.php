<div  class="form-group">
    <label class="form-label" for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <div class="custom-file">
        <input type="file" id="{{rand()}}" {{$attributes->wire('model')}} multiple="multiple" class="custom-file-input @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}">
        <label wire:loading.remove wire:target="{{$attributes->wire('model')->value}}" class="custom-file-label" for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
        <label wire:loading wire:target="{{$attributes->wire('model')->value}}" class="custom-file-label" for="{{$attributes->wire('model')->value}}">Uploading...</label>
        @error($attributes->wire('model')->value) <span class="error"><small>{{ $message }}</small></span> @else <div>Max upload size of {{$attributes['size']}} </div> @enderror
    </div>
</div>
