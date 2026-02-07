@push('css')
    <style>
        .breadcrumb-item+.breadcrumb-item::before {
            float: left;
            padding-right: .5rem;
            color: #6c757d;
            content: var(--bs-breadcrumb-divider, "/");
        }
    </style>
@endpush
<div>
    <x-slot name="title">
        Checkout
    </x-slot>
    <section class="inner-section single-banner" style="background: url(images/single-banner.jpg) no-repeat center;">
        <div class="container">
            <h2>checkout</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">checkout</li>
            </ol>
        </div>
    </section>
    <section class="inner-section checkout-part">
        <div class="container">
            <div class="row">
                @hasanyrole('superadmin|admin|manager|user|guest')
                    <div class="col-lg-12">
                        <div class="account-card">
                            <div class="account-title">
                                <h4>Delivery</h4>
                            </div>
                            <div class="account-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input.select wire:model.lazy="type" label="Delivery Type" :options="config('status.order_type')" />
                                    </div>
                                    <div class="col-md-12 @if ($type != 3) d-none @endif">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-search.dealer-search wire:model.lazy="dealer_id"
                                                    label="{{ config('mlm.dealer_name') }}" />
                                            </div>
                                            @if ($dealer)
                                                <div class="col-md-6">
                                                    Name : {{ $dealer->User->name }} ,<br />
                                                    Company Name : {{ $dealer->dealer_name }} ,<br />
                                                    Mobile : {{ $dealer->User->mobile }} ,<br />
                                                    Address : {{ $dealer->User->address }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 @if ($type != 1) d-none @endif">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-input.text wire:model.defer="name" label="Name" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-input.text wire:model.defer="mobile" label="Mobile No" />
                                            </div>
                                            <div class="col-md-12">
                                                <x-input.textarea wire:model.defer="address" label="Address" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endhasanyrole
                <div class="col-lg-12">
                    <div class="account-card">
                        <div class="account-title">
                            <h4>Your order</h4>
                        </div>
                        <div class="account-content">
                            <div class="table-scroll">
                                <table class="table-list">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serial</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Name</th>
                                            <th class="@if ($type == 1) d-none @endif" scope="col">
                                                Point</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">quantity</th>
                                            <th scope="col">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (collect($carts)->count() > 0)
                                            @foreach ($carts as $cart)
                                                <tr>
                                                    <td class="table-serial">
                                                        <h6>{{ $loop->iteration }}</h6>
                                                    </td>
                                                    <td class="table-image"><img
                                                            src="{{ asset_storage($cart->image_url) }}" alt="product">
                                                    </td>
                                                    <td class="table-name">
                                                        <h6>{{ $cart->name }}</h6>
                                                    </td>
                                                    <td
                                                        class="table-price @if ($type == 1) d-none @endif">
                                                        <h6>{{ pointformat($cart->point, true) }}</h6>
                                                    </td>
                                                    <td class="table-price">
                                                        <h6>{{ numberFormat($cart->net_price, true) }}</h6>
                                                    </td>
                                                    @if ($this->getStockCheck($cart->id, $cart->product_quantity))
                                                        <td class="table-quantity">
                                                            <h6>{{ $cart->product_quantity }}</h6>
                                                        </td>
                                                    @else
                                                        <td class="table-quantity bg-danger">
                                                            <h6>{{ $cart->product_quantity }}</h6>
                                                        </td>
                                                    @endif
                                                    <td class="table-action">
                                                        <a class="view"
                                                            href="{{ route('frontend.product', ['product_id' => $cart->id]) }}"
                                                            title="{{ $cart->name }}"><i class="fas fa-eye"></i></a>
                                                        <a class="trash" href="javascript:void(0)"
                                                            title="Remove To Cart"
                                                            wire:click="$dispatch('removeToCart','{{ $cart->id }}')"><i
                                                                class="icofont-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="checkout-charge">
                                <ul>
                                    <li><span>Total Amount</span> :
                                        <span>{{ numberformat(collect($carts)->sum('product_price_total'), true) }}</span>
                                    </li>
                                    <li class="@if ($type == 1) d-none @endif"><span>Total Point</span>
                                        :
                                        <span>{{ pointformat(collect($carts)->sum('product_point_total'), true) }}</span>
                                    </li>
                                    <li><span>Discount</span> :
                                        <span>{{ numberformat(collect($carts)->sum('product_discount_total'), true) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-0 account-card">
                        <div class="account-title ">
                            <h4>

                                Payment Details

                            </h4>
                        </div>
                        <div class="account-content">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 alert fade show">
                                    <x-input.select wire:model.lazy="payment_method_id" label="Payment Method"
                                        :options="config('status.order_payment_method')" />
                                </div>
                                <div
                                    class="col-md-6 col-lg-4 alert fade show @if ($payment_method_id != 2) d-none @endif">
                                    <div class="payment-card payment">
                                        <h5>{{ numberFormat($Balance->available_balance, true) }}</h5>
                                        <h4>Available Account Balance</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout-check mt-2"><input type="checkbox" id="checkout-check"><label
                                for="checkout-check">By making this purchase you agree to our <a
                                    href="{{ route('frontend.terms_and_condition') }}" target="_blank">Terms and
                                    Conditions</a>.</label></div>
                        <div class="checkout-proced"><x-button.default class="btn btn-inline" wire:click="orderComplete"
                                wire:target="orderComplete">proced to checkout</x-button.default></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
