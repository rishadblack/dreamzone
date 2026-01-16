<div>
    <x-slot name="header">Checkout</x-slot>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card cart">
                <div class="card-header">
                    <div class="card-title">Shopping Cart</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th class="w-25">Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <img src="{{ asset('backend/images/products/28.png') }}" alt=""
                                            class="h-8">
                                    </td>
                                    <td>New Headphones</td>
                                    <td class="fw-bold">৳568</td>
                                    <td>
                                        <div class="handle-counter input-indec" id="handleCounter1"> <button
                                                type="button" class="counter-minus btn btn-light btn-number"
                                                data-type="minus" data-field=""> <i class="fa fa-minus"></i> </button>
                                            <input type="text" value="2" class="qty"> <button type="button"
                                                class="counter-plus btn btn-light btn-number" data-type="plus"
                                                data-field=""> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </td>
                                    <td> <a href="javascript:void(0)" class="btn btn-danger  btn-sm me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            aria-label="Save for Washlist" data-bs-original-title="Save for Washlist"><i
                                                class="icon icon-heart  fs-16"></i></a> <a href="javascript:void(0)"
                                            class="btn btn-info  btn-sm me-3" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Remove"
                                            data-bs-original-title="Remove"><i class="icon icon-trash  fs-16"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <img src="{{ asset('backend/images/products/30.png') }}" alt=""
                                            class="h-8">
                                    </td>
                                    <td>Kids School Bag</td>
                                    <td class="fw-bold">৳1,027</td>
                                    <td>
                                        <div class="handle-counter input-indec" id="handleCounter2"> <button
                                                type="button" class="counter-minus btn btn-light btn-number"
                                                data-type="minus" data-field=""> <i class="fa fa-minus"></i> </button>
                                            <input type="text" value="4" class="qty"> <button type="button"
                                                class="counter-plus btn btn-light btn-number" data-type="plus"
                                                data-field=""> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </td>
                                    <td> <a href="javascript:void(0)" class="btn btn-danger  btn-sm me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            aria-label="Save for Washlist" data-bs-original-title="Save for Washlist"><i
                                                class="icon icon-heart  fs-16"></i></a> <a href="javascript:void(0)"
                                            class="btn btn-info  btn-sm me-3" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Remove"
                                            data-bs-original-title="Remove"><i class="icon icon-trash  fs-16"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <img src="{{ asset('backend/images/products/29.png') }}" alt=""
                                            class="h-8">
                                    </td>
                                    <td>Shopping Bag</td>
                                    <td class="fw-bold">৳1,589</td>
                                    <td>
                                        <div class="handle-counter input-indec" id="handleCounter3"> <button
                                                type="button" class="counter-minus btn btn-light btn-number"
                                                data-type="minus" data-field=""> <i class="fa fa-minus"></i> </button>
                                            <input type="text" value="1" class="qty"> <button type="button"
                                                class="counter-plus btn btn-light btn-number" data-type="plus"
                                                data-field=""> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </td>
                                    <td> <a href="javascript:void(0)" class="btn btn-danger  btn-sm me-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            aria-label="Save for Washlist"
                                            data-bs-original-title="Save for Washlist"><i
                                                class="icon icon-heart  fs-16"></i></a> <a href="javascript:void(0)"
                                            class="btn btn-info  btn-sm me-3" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-label="Remove"
                                            data-bs-original-title="Remove"><i class="icon icon-trash  fs-16"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                    <div class="row">
                        <div class="col-6"><input class="productcart form-control" type="text"
                                placeholder="Coupon Code"></div>
                        <div class="col-6"><a href="#" class="btn btn-primary btn-md">Apply Coupon</a></div>
                    </div><br>
                    <div class="mt-3">
                        <h5 class="my-4">Order Summery</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center">
                                <tbody class="text-dark">
                                    <tr>
                                        <td>Cart Subtotal</td>
                                        <td class="text-end">৳485.00</td>
                                    </tr>
                                    <tr>
                                        <td><span>Discount</span></td>
                                        <td class="text-end text-success"><span>0.5%</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>Totals</span></td>
                                        <td class="text-end text-muted"><span>৳456.00</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>Order Total</span></td>
                                        <td>
                                            <h2 class="price text-end text-primary mb-0">৳456.00</h2>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end"> <a href="{{ route('ecommerce.shop') }}"
                        class="btn btn-primary mt-2"><i class="fa fa-arrow-left me-1"></i>Continue Shopping</a>
                    <button type="button" class="btn btn-success mt-2">Check out<i
                            class="fa fa-arrow-right ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
