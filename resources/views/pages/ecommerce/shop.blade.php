<div>
    <x-slot name="header">Shopping</x-slot>
    <div class="row">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"> Categories &amp; Fliters</div>
                        </div>
                        <div class="card-body">
                            <x-input.select label="Category">
                                <option value="0">--Select--</option>
                                <option value="1">Dress</option>
                                <option value="2">Bags &amp; Purses</option>
                                <option value="3">Coat &amp; Jacket</option>
                                <option value="4">Beauty</option>
                                <option value="5">Jeans</option>
                                <option value="5">Jewellery</option>
                                <option value="5">Electronics</option>
                                <option value="5">Sports</option>
                                <option value="5">Technology</option>
                                <option value="5">Watches</option>
                                <option value="5">Accessories</option>
                            </x-input.select>
                            <x-input.select label="Brand">
                                <option value="0">--Select--</option>
                                <option value="1">White</option>
                                <option value="2">Black</option>
                                <option value="3">Red</option>
                                <option value="4">Green</option>
                                <option value="5">Blue</option>
                                <option value="6">Yellow</option>
                            </x-input.select>
                            <x-input.select label="Type">
                                <option value="0">--Select--</option>
                                <option value="1">Service</option>
                                <option value="2">Product</option>
                            </x-input.select>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body p-2">
                    <div class="col-sm-12 p-0">
                        <div class="input-group"> <button class="btn btn-primary" type="button">Search</button>
                            <input type="text" class="form-control" placeholder="Search ...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card">
                        <div class="ribbone">
                            <div class="ribbon float-start"><span>new</span></div>
                        </div>
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/16.png') }}" alt="img"> </a> </div>
                            <div class="product-content text-center">
                                <div class="mb-2 text-warning"> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i
                                        class="fa fa-star-o"></i>
                                </div>
                                <h4 class="title text-primary"><a href="javascript:void(0);">Mens Jacket</a></h4>
                                <div class="price"> <span>৳699</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳999</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search "></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card"> <span class="ribbon1"> <span>25%</span> </span>
                        <div class="product-grid6 card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/29.png') }}" alt="img"> </a> </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i
                                        class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                                <h4 class="title text-primary"><a href="javascript:void(0);">Shopping Bag</a></h4>
                                <div class="price"> <span>৳529</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳799</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i class="fa fa-search"></i></a>
                                </li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card">
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/9.png') }}" alt="img"> </a> </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <h4 class="title"><a href="javascript:void(0);">Mens Shoes</a></h4>
                                <div class="price"> <span>৳239</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳399</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card"> <span class="ribbon1"> <span>25%</span> </span>
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/30.png') }}" alt="img"> </a>
                            </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> </div>
                                <h4 class="title"><a href="javascript:void(0);">Kids Bag</a></h4>
                                <div class="price"> <span>৳345</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳459</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card">
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/19.png') }}" alt="img"> </a>
                            </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <h4 class="title"><a href="javascript:void(0);">Head Phone</a></h4>
                                <div class="price"> <span>৳567</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳866</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card">
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/22.png') }}" alt="img"> </a>
                            </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i
                                        class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                                <h4 class="title"><a href="javascript:void(0);">Novel Book</a></h4>
                                <div class="price"> <span>৳455</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳567</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card">
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/5.png') }}" alt="img"> </a>
                            </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> </div>
                                <h4 class="title"><a href="javascript:void(0);">Gold Watch</a></h4>
                                <div class="price"> <span>৳345</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳499</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card item-card"> <span class="ribbon1"> <span>30%</span> </span>
                        <div class="product-grid6  card-body">
                            <div class="product-image6"> <a href="javascript:void(0);"> <img class="img-fluid"
                                        src="{{ asset('backend/images/products/6.png') }}" alt="img"> </a>
                            </div>
                            <div class="product-content text-center">
                                <div class="text-center mb-2 text-warning"> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                                <h4 class="title"><a href="javascript:void(0);">Sport shoes</a></h4>
                                <div class="price"> <span>৳543</span> <span
                                        class="ms-4 text-muted text-decoration-line-through">৳688</span> </div>
                            </div>
                            <ul class="icons">
                                <li><a href="product-search.html" data-tip="Quick View"><i
                                            class="fa fa-search"></i></a></li>
                                <li></li>
                                <li><a href="wishlist.html" data-tip="Quick View"><i class="fa fa-heart-o"></i></a>
                                </li>
                                <li></li>
                                <li><a href="{{ route('ecommerce.checkout') }}" data-tip="Quick View"><i
                                            class="fa fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 float-end">
                <ul class="pagination ">
                    <li class="page-item page-prev disabled"> <a class="page-link" href="#"
                            tabindex="-1">Prev</a> </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item page-next"> <a class="page-link" href="#">Next</a> </li>
                </ul>
            </div>
        </div><!-- COL-END -->
    </div>
</div>
