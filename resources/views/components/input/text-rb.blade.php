<div class="form-group">
    <div class="d-flex justify-content-between">
        <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>@if($attributes['lang_options']) <select wire:model='select_lang' id="select_lang" name="select_lang"><option value="en">English</option><option value="bn">Bangla</option></select> @endif
    </div>
    <div class="input-group">
        <input @if($attributes['read-only']) readonly @endif type="text"aria-describedby="{{$attributes->wire('model')->value}}"  {{$attributes->wire('model')}} id="{{$attributes->wire('model')->value}}" class="form-control @error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" placeholder="{{ $attributes['placeholder'] }}">
        <div class="input-group-append" id="{{$attributes->wire('model')->value}}">
            <button class="btn btn-primary waves-effect" type="button" wire:click="{{$attributes['button-event']}}" wire:loading.attr="disabled" wire:target="{{$attributes['button-event']}}" >
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading wire:target="{{$attributes['button-event']}}"></span>
                <span wire:loading.remove wire:target="{{$attributes['button-event']}}">{{$attributes['button-text']}}</span>
                <span wire:loading wire:target="{{$attributes['button-event']}}">Processing...</span>
            </button>
        </div>
        @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
