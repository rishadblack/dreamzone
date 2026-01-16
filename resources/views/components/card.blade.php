<div class="card {{ $attributes['class'] }}">
    @isset($card_title)
        <div class="card-header">
            <div class="card-title">{{ $card_title }}</div>
        </div>
    @endisset
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
