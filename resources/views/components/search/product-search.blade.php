<div>
    <div wire:ignore x-data="loadProductSearchData()" x-init="init">
        <select x-ref="selectProduct" id="{{ $attributes->wire('model')->value }}" {{ $attributes->wire('model') }} placeholder="{{ $attributes['placeholder'] }}" class="@error($attributes->wire('model')->value) is-invalid @enderror {{ $attributes['class'] }}" {{ $attributes['required'] }}></select>
    </div>
    @error($attributes->wire('model')->value) <div class="error" style="color:red">{{ $message }}</div> @enderror
</div>
@push('scripts')
<script>
    function loadProductSearchData() {
        return {
            selectValue: @entangle($attributes->wire('model')),
            init(){
                this.initAlpineProductData();
            },
            initAlpineProductData() {
                var config = {
                    valueField: 'id',
                    labelField: 'text',
                    searchField: ['text','id'],
                    load: (query, callback) => {
                        axios.get("{{route('backend.search.data', ['type' => 'product'])}}", {
                            params: {
                                search: query
                            }
                        })
                        .then(response => {
                            callback(response.data);
                        }).catch(function (error) {
                            callback();
                        });
                    },
                    render: {
                        option: function(item, escape) {
                            return `<div class="py-1 d-flex">
                                        <div class="icon me-3 mr-1">
                                            <img class="img-fluid" src="${item.image_url}?h=30&fit=stretch" />
                                        </div>
                                        <div>
                                            <div class="mb-1">
                                                <span class="h4">
                                                     ${ escape(item.text) }
                                                </span>
                                                <span class="text-muted">Code : ${ escape(item.code) }</span>
                                            </div>
                                        </div>
                                    </div>`;
                        },
                    }
                };

                this.selectProduct =  new TomSelect(this.$refs.selectProduct,config);

                window.addEventListener("{{ $attributes->wire('model')->value }}_reset", event => {
                        this.selectProduct.clear();
                });

                window.addEventListener("{{ $attributes->wire('model')->value }}_update", event => {
                    this.selectProduct.addOption({
                            id: event.detail.id,
                            text: event.detail.text
                        });
                    this.selectProduct.setValue(event.detail.id);
                });

                window.addEventListener("typeahead_reset", event => {
                    this.selectProduct.clear();
                });
            }
        }
    }
</script>
@endpush
