<div>
    <div wire:ignore x-data="loadSelectData{{ $attributes->wire('model')->value }}()" x-init="init">
        <select x-ref="selectTypeaHead" {{ $attributes->wire('model') }} data-placeholder="{{ $attributes['placeholder'] }}" class="@error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}"></select>
        @error($attributes->wire('model')->value) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
@push('scripts')
<script>
    function loadSelectData{{ $attributes->wire('model')->value }}() {
        return {
            selectValue: @entangle($attributes->wire('model')),
            init(){
                this.selectUpdate{{ $attributes->wire('model')->value }}();
                this.selectAlpine{{ $attributes->wire('model')->value }}();
            },
            selectUpdate{{ $attributes->wire('model')->value }}() {
                if(this.selectValue){
                    axios.get("{{route('backend.search.data', ['type' => $attributes['search-type']])}}",{
                            params: {
                                value: this.selectValue
                            }
                        })
                    .then(response => {

                        console.log(response.data);
                        this.select2.addOption({
                            id: response.data.id,
                            name: response.data.name
                        });
                        this.select2.setValue(response.data.id);
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            selectAlpine{{ $attributes->wire('model')->value }}() {
                var config = {
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name','id'],
                    @if($attributes['search-create'])
                    create: (input) => {
                        @this.call("{{$attributes['search-create']}}", input);
                        return false;
                    },
                    @endif
                    load: (query, callback) => {
                        axios.get("{{route('backend.search.data', ['type' => $attributes['search-type']])}}", {
                            params: {
                                search: query
                            }
                        })
                        .then(response => {
                            callback(response.data);
                        }).catch(function (error) {
                            callback();
                        });
                    }
                };

                this.select2 =  new TomSelect(this.$refs.selectTypeaHead,config);

                // this.$watch("selectValue", (value) => {
                //     if(!value){
                //         this.select2.clear();
                //     }
                // });

                window.addEventListener("{{ $attributes->wire('model')->value }}", event => {
                    if(event.detail == 'reset'){
                        this.select2.clear();
                    }else{
                        this.selectUpdate{{ $attributes->wire('model')->value }}();
                    }
                });
            }
        }
    }
</script>
@endpush
