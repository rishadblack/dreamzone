<div>
    <x-slot name="title">
        Product
    </x-slot>

    <section wire:ignore class="single-banner inner-section"
        style="background: url(images/single-banner.jpg) no-repeat center;">
        <div class="container">
            <h2>product simple</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.shop') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </div>
    </section>
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="details-gallery" wire:ignore>
                        <ul class="details-preview">
                            @foreach ($product->Images as $image)
                                <li><img src="{{ asset_storage($image->image_url) }}" width="600"
                                        alt="{{ $product->name }}"></li>
                            @endforeach
                        </ul>
                        <ul class="details-thumb">
                            @foreach ($product->Images as $image)
                                <li><img src="{{ asset_storage($image->image_url) }}" width="100"
                                        alt="{{ $product->name }}"></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="details-content">
                        <h3 class="details-name"><a href="#">{{ $product->name }}</a></h3>
                        <div class="details-meta">
                            <p>SKU:<span>{{ $product->code }}</span></p>
                            <p>BRAND:<a href="#">{{ $product->brand_id ? $product->Brand->name : '' }}</a></p>
                        </div>
                        <h3 class="details-price">
                            @if ($product->discount_price)
                                <del>{{ numberFormat($product->sales_price, true) }}</del>
                            @endif
                            <span>{{ numberFormat($product->net_price, true) }}<small>/piece</small></span>
                        </h3>
                        <p class="details-desc">{{ $product->short_description }}</p>
                        <div class="details-list-group"><label class="details-list-title">Share:</label>
                            <ul class="details-share-list">
                                <li><a href="#" class="icofont-facebook" title="Facebook"></a></li>
                                <li><a href="#" class="icofont-twitter" title="Twitter"></a></li>
                                <li><a href="#" class="icofont-linkedin" title="Linkedin"></a></li>
                                <li><a href="#" class="icofont-instagram" title="Instagram"></a></li>
                            </ul>
                        </div>

                        <div class="details-add-group">
                            <button
                                class="product-added btn btn-block btn-success {{ cartProductExists($product->id) ? '' : 'd-none' }}"
                                title="Added in Cart"><i class="fas fa-shopping-basket"></i><span>added</span></button>
                            <button class="product-add {{ cartProductExists($product->id) ? 'd-none' : '' }}"
                                title="Add to Cart" wire:click="$dispatch('addToCart','{{ $product->id }}')"><i
                                    class="fas fa-shopping-basket"></i><span>add</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-details-frame">
                        <h3 class="frame-title">Description</h3>
                        <div class="tab-descrip">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-heading">
                        <h2>related this items</h2>
                    </div>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                @foreach ($related_products as $related_product)
                    <div class="col">
                        <livewire:frontend.component.product-card-component :key="'response-' . $related_product->id" :productId="$related_product->id" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
