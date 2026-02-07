<div>
    <x-slot name="title">
        Home
    </x-slot>
    <div class="banner-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="home-category-slider slider-arrow slider-dots">
                        @foreach ($home_slides as $home_slide)
                            <a href="{{ $home_slide->link }}">
                                <img src="{{ asset_storage($home_slide->image_url) }}" alt="{{ $home_slide->title }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <section class="suggest-part">
            <div class="container">
                <ul class="suggest-slider slider-arrow">
                    @foreach ($categories as $category)
                        <li>
                            <a class="suggest-card"
                                href="{{ route('frontend.shop', ['category_id' => $category->id]) }}"><img
                                    src="{{ asset_storage($category->image_url) }}" width="250" height="120"
                                    alt="{{ $category->name }}">
                                <h5>{{ $category->name }}</h5>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        <div class="section promo-part">
            <div class="container">
                <div class="row">
                    @foreach ($home_banners as $home_banner)
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="promo-img"><a href="{{ $home_banner->link }}"><img
                                        src="{{ asset_storage($home_banner->image_url) }}"
                                        alt="{{ $home_banner->title }}"></a></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <section class="section feature-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>our featured items</h2>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">

                    @foreach ($featured_products as $featured_product)
                        <div class="col">
                            <livewire:frontend.component.product-featured-component :productId="$featured_product->id" />
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-btn-25"><a href="{{ route('frontend.shop') }}" class="btn btn-outline"><i
                                    class="fas fa-eye"></i><span>show more</span></a></div>
                    </div>
                </div>
            </div>
        </section>
        <div class="section promo-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="promo-img"><a href="#"><img
                                    src="{{ asset('frontend/images/promo/home/03.jpg') }}" alt="promo"></a></div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($featured_categories as $featured_category)
            <section class="section newitem-part">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section-heading">
                                <h2>{{ $featured_category->name }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <ul class="new-slider slider-arrow">
                                @foreach ($featured_category->Products()->limit(50)->get() as $Product)
                                    <li>
                                        <livewire:frontend.component.product-card-component :productId="$Product->id" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="section-btn-25">
                                <a href="{{ route('frontend.shop', ['category_id' => $featured_category->id]) }}"
                                    class="btn btn-outline"><i class="fas fa-eye"></i><span>show more</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>
