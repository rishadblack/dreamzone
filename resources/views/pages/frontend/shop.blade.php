<div>
    <x-slot name="title">
        Shop
    </x-slot>

    <section wire:ignore class="inner-section single-banner" style="background: url({{asset('frontend/images/single-banner.jpg')}}) no-repeat center;">
        <div class="container">
            <h2>Shop</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('frontend.home')}}">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </div>
    </section>
    <section class="inner-section shop-part">
        <div class="container">
            <div class="row content-reverse">
                <div class="col-lg-3">
                    <div class="shop-widget">
                        <h6 class="shop-widget-title">Filter by Brand</h6>
                        <form>
                            <ul class="shop-widget-list shop-widget-scroll">
                                @foreach ($brands as $key => $brand)
                                <li>
                                    <div class="shop-widget-content">
                                        <input type="checkbox" wire:model="brandIds" value="{{$brand->id}}" wire:key="{{$brand->id}}" id="{{$brand->id}}">
                                        <label for="{{$brand->id}}">{{$brand->name}}</label>
                                    </div>
                                    <span class="shop-widget-number">({{$brand->products_count}})</span>
                                </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                    <div class="shop-widget">
                        <h6 class="shop-widget-title">Filter by Category</h6>
                        <form>
                            <ul class="shop-widget-list shop-widget-scroll">
                                @foreach ($categories as $key => $category)
                                <li>
                                    <div class="shop-widget-content">
                                        <input type="checkbox" wire:model="categoryIds" value="{{$category->id}}" wire:key="{{$category->id}}" id="{{$category->id}}">
                                        <label for="{{$category->id}}">{{$category->name}}</label>
                                    </div>
                                    <span class="shop-widget-number">({{$category->products_count}})</span>
                                </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="top-filter">
                                <div class="filter-show"><label class="filter-label">Show :</label>
                                    <select class="form-select filter-select" wire:model="paginate_show">
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                        <option value="48">48</option>
                                    </select></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">
                        @foreach ($products as $product)
                            <div class="col">
                                <livewire:frontend.component.product-card-component :key="'response-'.$product->id" :productId="$product->id" />
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{$products->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
