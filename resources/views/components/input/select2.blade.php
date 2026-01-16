<div class="mt-2">
    <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <div wire:ignore>
        <select @if($attributes['multiple']) multiple="{{ $attributes['multiple'] }}" @endif id="{{$attributes->wire('model')->value}}" class="form-control select2 {{ $attributes['class'] }}" {{$attributes->wire('model')}}>
            <option value="">{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Select '.$attributes['label'] }}</option>
            @if (isset($attributes['options']))
                @if(count($attributes['options']) > 0)
                    @foreach($attributes['options'] as $key=>$option)
                        <option value="{{$key}}" >{{$option}}</option>
                    @endforeach
                @endif
            @else
            {{$slot}}
            @endif
        </select>
    </div>
    @error($attributes->wire('model')->value)<div class="invalid-feedback">{{ $message }}</div> @enderror
    {{-- @error($attributes->wire('model')->value) <div class="error" style="color:red">{{ $message }}</div> @enderror --}}
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $("#{{$attributes->wire('model')->value}}").select2({
                placeholder: "{{ isset($attributes['placeholder']) ? $attributes['placeholder'] : 'Select '.$attributes['label'] }}",
                allowClear: true,
                width: '100%',
                tags: true,
                dropdownParent: $('.modal'),
                createTag: function (tag) {
                    return {
                        id: tag.term,
                        text: tag.term,
                        isNew : true
                    };
                }
                }).on("select2:select", function(e) {
                if(e.params.data.isNew){
                    console.log('create New');
                }else{
                    @this.set("{{ $attributes['wire:model'] }}",$(this).val());
                }
            });
        });


        // $('#testModal').on('show.bs.modal', function() {
        //     $('#{{$attributes->wire('model')->value}}').select2({
        //         dropdownParent: $('#testModal')
        //     });
        // })

        window.addEventListener('select2update', event => {
            $("#{{$attributes->wire('model')->value}}").val($("#{{$attributes->wire('model')->value}}").val()).trigger('change');
        });

        window.addEventListener('select2reset', event => {
            $("#{{$attributes->wire('model')->value}}").val('').trigger('change');
        });
    </script>
@endpush
