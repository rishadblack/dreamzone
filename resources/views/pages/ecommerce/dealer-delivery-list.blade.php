<div>
    <x-slot name="title">Order Delivery List</x-slot>
    <x-slot name="header">Order Delivery List</x-slot>

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <livewire:ecommerce.datatable.order-delivery-table />

                <x-modal id="OrderModal" title="Received Order" size="lg">
                    @if ($order)
                        <div class="mt-2 row">
                            <div class="col-lg-6">
                                <p class="mb-0">INVOICE TO</p>
                                <h5 class="mb-0"><b>{{ $order->User->name }} ({{ $order->User->username }})</b></h5>
                                <p class="mb-0">
                                    {{ $order->delivery_company ? $order->delivery_company : $order->User->company }}
                                </p>
                                <p class="mb-0">
                                    {{ $order->delivery_mobile ? $order->delivery_mobile : $order->User->mobile }}</p>
                                <p class="mb-0">
                                    {{ $order->delivery_address ? $order->delivery_address : $order->User->address }}
                                </p>
                                <p class="mt-2 mb-0">DELIVERY BY</p>
                                <h6 class="mb-0"><b>{{ $order->Dealer->User->name }}
                                        ({{ $order->Dealer->User->username }})</b></h6>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>Invoice No</td>
                                                    <td class="px-3">:</td>
                                                    <td>#{{ $order->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Order Date</td>
                                                    <td class="px-3">:</td>
                                                    <td>{{ $order->created_at->format(getTimeFormat()) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method</td>
                                                    <td class="px-3">:</td>
                                                    <td>{{ config('status.order_payment_method.' . $order->payment_method_id . '.name') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Status</td>
                                                    <td class="px-3">:</td>
                                                    <td>{{ config('status.order_payment_status.' . $order->payment_status . '.name') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Delivery Status</td>
                                                    <td class="px-3">:</td>
                                                    <td>{{ config('status.order_delivery_status.' . $order->delivery_status . '.name') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">ITEM DESCREPTION</th>
                                            <th scope="col">{{ config('mlm.point_name') }}</th>
                                            <th scope="col">PRICE</th>
                                            <th scope="col">QTY</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItem as $item)
                                            <tr>
                                                <td>{{ $item->Product->code }}</td>
                                                <td>
                                                    <b>{{ $item->Product->name }}</b>
                                                </td>
                                                <td>{{ pointFormat($item->point, true) }}</td>
                                                <td>{{ numberFormat($item->price + $item->discount_amount, true) }}
                                                </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ numberFormat($item->discount_amount, true) }}</td>
                                                <td>{{ numberFormat($item->net_amount, true) }}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="5"></td>
                                            <td><b>Sub Total</b></td>
                                            <td><b>{{ numberFormat($order->subtotal + $order->discount_amount, true) }}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td><b>Discount (-)</b></td>
                                            <td><b>{{ numberFormat($order->discount_amount, true) }}</b></td>
                                        </tr>
                                        <tr style="background: #E6E4E7; color: #0099D5;">
                                            <td colspan="5"></td>
                                            <td><b>GRAND TOTAL</b></td>
                                            <td><b>{{ numberFormat($order->net_amount, true) }}</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td><b>TOTAL {{ config('mlm.point_name') }}</b></td>
                                            <td><b>{{ pointFormat($order->point, true) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <x-input.select wire:model.live="payment_status" label="Payment Status"
                                    :options="config('status.order_payment_status')" />
                            </div>
                            <div class="col-lg-4">
                                <x-input.select wire:model.live="delivery_status" label="Delivery Status"
                                    :options="config('status.order_delivery_status')" />
                            </div>
                        </div>
                    @endif
                </x-modal>
            </x-card>
        </div>
    </div>
</div>
