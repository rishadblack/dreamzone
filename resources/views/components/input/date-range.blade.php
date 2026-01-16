<div class="mt-2">
    <label for="{{$attributes->wire('model')->value}}">{{ $attributes['label'] }}</label>
    <div wire:ignore>
        <input id="{{$attributes->wire('model')->value}}" @if($attributes['read-only']) readonly @endif type="text" id="{{$attributes->wire('model')->value}}" class="form-control  @error($attributes->wire('model')->value) is-invalid @enderror {{$attributes['class']}}" placeholder="{{ $attributes['placeholder'] }}" >
    </div>
    @error($attributes->wire('model')->value) <div class="error" style="color:red">{{ $message }}</div> @enderror
</div>
@push('js')
<script>
        $('#{{$attributes->wire('model')->value}}').daterangepicker({
            "timePicker": true,
            showDropdowns: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                'All Time': ['01-01-1950', moment()]
            },
            locale: {
                format: 'DD-MM-YYYY hh:mm A'
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
        }, function(start, end, label) {
            @isset($attributes['loadJs'])
            @else
                @this.set("{{ $attributes['wire:model'] }}",start.format('DD-MM-YYYY hh:mm A') + ' to ' + end.format('DD-MM-YYYY hh:mm A'));
            @endisset
        });

        window.drp_{{$attributes->wire('model')->value}} = $('#{{$attributes->wire('model')->value}}').data('daterangepicker');
</script>

@endpush
@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
