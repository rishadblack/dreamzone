<div class="form-group">
    @if($attributes['label'])<label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>@endif
    <select id="{{$attributes->wire('model')->value}}" {{$attributes->wire('model')}} class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{$attributes['class']}}">
        <option value="">{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Select '.$attributes['label'] }}</option>
        @foreach ($packages as $package)
            <option value="{{$package->id}}">{{$package->name}}</option>
        @endforeach
    </select>
    @error($attributes->wire('model')->value)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
