@isset($attributes['sub'])
    <div class="menu-item has-sub @if (in_array($attributes['sub'], explode('.', Route::currentRouteName()))) active @endif">
        <a href="#" class="menu-link">
            @isset($attributes['icon'])
                <span class="menu-icon">
                    <i class="{{ $attributes['icon'] }}"></i>
                </span>
            @endisset
            <span class="menu-text">{{ $attributes['label'] }}</span>
            <span class="menu-caret"><b class="caret"></b></span>
        </a>
        <div class="menu-submenu">
            {{ $slot }}
        </div>
    </div>
@else
    @if (isset($attributes['route_parameter']))
        <div class="menu-item @if (Route::currentRouteName() == $attributes['route'] && matchRouteParameter($attributes['route_parameter'])) active @endif">
            <a href="{{ route($attributes['route'], $attributes['route_parameter']) }}" wire:navigate class="menu-link">
                <span class="menu-text">{{ $attributes['label'] }}</span>

            </a>
        </div>
    @else
        <div class="menu-item @if (Route::currentRouteName() == $attributes['route']) active @endif">
            <a href="{{ route($attributes['route']) }}" wire:navigate class="menu-link">
                <span class="menu-text">{{ $attributes['label'] }}</span>
            </a>
        </div>
    @endif
@endisset
