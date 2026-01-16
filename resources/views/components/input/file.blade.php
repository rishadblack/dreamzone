<div  class="form-group bg_transparent">
    @isset($attributes['label'])
        <label class="form-label" for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    @endisset
    <div class="custom-file">
        <input type="file" id="{{$attributes->wire('model')->value}}-{{rand()}}" {{$attributes->wire('model')}} class="custom-file-input @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}">
        <label wire:loading.remove wire:target="{{$attributes->wire('model')->value}}" class="custom-file-label" for="{{$attributes->wire('model')->value}}"></label>
        <label wire:loading wire:target="{{$attributes->wire('model')->value}}" class="custom-file-label" for="{{$attributes->wire('model')->value}}">Uploading...</label>
        @error($attributes->wire('model')->value) <span class="error"><small>{{ $message }}</small></span> @else <span>Max {{$attributes['size']}} </span> @enderror
    </div>
</div>
