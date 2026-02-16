<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="template" content="{{ config('app.name') }}">
    <meta name="title" content="{{ config('app.name') }}">
    <meta name="keywords" content="{{ config('app.name') }}">
    <title>{{ $title ? $title . ' |' : '' }} {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fontawesome/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/venobox/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/slickslider/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/niceselect/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/bootstrap.min.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/home-category.css') }}">
    @livewireStyles
    @livewireScripts
    @vite(['resources/sass/frontend.scss', 'resources/js/frontend.js'])
</head>

<body>
    <div class="backdrop"></div><a class="backtop fas fa-arrow-up" href="#"></a>
    @if (!isApp())
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-5">
                        <div class="header-top-welcome">
                            <p>Welcome to {{ config('app.name') }} in Your Dream Online Store!</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-3">
                        {{-- <div class="header-top-select">
                        <div class="header-select"><i class="icofont-world"></i><select class="select">
                                <option value="english" selected>english</option>
                                <option value="bangali">bangali</option>
                                <option value="arabic">arabic</option>
                            </select></div>
                        <div class="header-select"><i class="icofont-money"></i><select class="select">
                                <option value="english" selected>doller</option>
                                <option value="bangali">pound</option>
                                <option value="arabic">taka</option>
                            </select></div>
                    </div> --}}
                    </div>
                    <div class="col-md-7 col-lg-4">
                        <ul class="header-top-list">
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Sign Up</a></li>
                            <li><a href="{{ route('frontend.contact') }}">contact us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <header class="header-part">
            <div class="container">
                <div class="header-content">
                    <div class="header-media-group">
                        <button class="header-user">
                            <span class="fas fa-list"></span>
                        </button>
                        <a href="{{ config('app.url') }}"><img src="{{ asset_logo() }}" alt="logo"></a>
                        <button class="header-src"><i class="fas fa-search"></i></button>
                    </div>
                    <a href="{{ config('app.url') }}" class="header-logo">
                        <img src="{{ asset_logo() }}" alt="logo">
                    </a>
                    @auth
                        <a href="{{ route('backend.dashboard') }}" class="header-widget" title="My Account">
                            {{-- <img
                                src="{{ asset('frontend/images/user.png') }}" alt="user"> --}}
                            <span>Dashboard</span></a>
                    @endauth
                    <form class="header-form">
                        <input type="text" placeholder="Search anything...">
                        <button><i class="fas fa-search"></i></button>
                    </form>
                    <div class="header-widget-group">
                        {{-- <a href="compare.html" class="header-widget" title="Compare List"><i class="fas fa-random"></i><sup>0</sup></a>
                    <a href="wishlist.html" class="header-widget" title="Wishlist"><i class="fas fa-heart"></i><sup>0</sup></a> --}}
                        <livewire:frontend.component.cart-total />
                    </div>
                </div>
            </div>
        </header>
    @endif
    <nav class="navbar-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-content">
                        <ul class="navbar-list">
                            <li class="navbar-item"><a class="navbar-link" href="{{ route('frontend.home') }}">home</a>
                            </li>
                            <li class="navbar-item dropdown"><a class="navbar-link dropdown-arrow"
                                    href="#">Categories</a>
                                <ul class="dropdown-position-list">
                                    @foreach (App\Models\Category::active()->get() as $category)
                                        <li><a
                                                href="{{ route('frontend.shop', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="navbar-item"><a class="navbar-link" href="{{ route('frontend.shop') }}">Shop</a>
                            </li>
                            <li class="navbar-item"><a class="navbar-link"
                                    href="{{ route('frontend.about_us') }}">About Us</a></li>
                            <li class="navbar-item"><a class="navbar-link"
                                    href="{{ route('frontend.contact') }}">Contact Us</a></li>
                        </ul>
                        <div class="navbar-info-group">
                            <div class="navbar-info"><i class="icofont-ui-touch-phone"></i>
                                <p><small>call us</small><span>{{ config('app.phone') }}</span></p>
                            </div>
                            <div class="navbar-info"><i class="icofont-ui-email"></i>
                                <p><small>email us</small><span>{{ config('app.email') }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <aside class="category-sidebar">
        <div class="category-header">
            <h4 class="category-title"><i class="fas fa-align-left"></i><span>categories</span></h4><button
                class="category-close"><i class="icofont-close"></i></button>
        </div>
        <ul class="category-list">
            @foreach (App\Models\Category::active()->get() as $category)
                <li class="category-item"><a class="category-link"
                        href="{{ route('frontend.shop', ['category_id' => $category->id]) }}"><i
                            class="flaticon-vegetable"></i><span>{{ $category->name }}</span></a></li>
            @endforeach
        </ul>
        <div class="category-footer">
            <p>All Rights Reserved by <a href="{{ config('app.url') }}">{{ config('app.name') }}</a></p>
        </div>
    </aside>
    <livewire:frontend.component.cart-list-component />
    <aside class="nav-sidebar">
        <div class="nav-header"><a href="{{ route('frontend.home') }}"><img src="{{ asset_logo() }}"
                    alt="logo"></a><button class="nav-close"><i class="icofont-close"></i></button></div>
        <div class="nav-content">
            <ul class="nav-list">
                <li><a class="nav-link" href="{{ route('frontend.home') }}"><i class="icofont-home"></i>Home</a>
                </li>
                <li><a class="nav-link" href="{{ route('login') }}"><i class="icofont-logout"></i>Login</a></li>
            </ul>
            <div class="nav-info-group">
                <div class="nav-info"><i class="icofont-ui-touch-phone"></i>
                    <p><small>call us</small><span>{{ config('app.phone') }}</span></p>
                </div>
                <div class="nav-info"><i class="icofont-ui-email"></i>
                    <p><small>email us</small><span>{{ config('app.email') }}</span></p>
                </div>
            </div>
            <div class="nav-footer">
                <p>All Rights Reserved by <a href="{{ config('app.url') }}">{{ config('app.name') }}</a></p>
            </div>
        </div>
    </aside>
    <div class="mobile-menu">
        <a href="{{ config('app.url') }}" title="Home Page">
            <i class="fas fa-home"></i><span>Home</span>
        </a><button class="cate-btn" title="Category List"><i class="fas fa-list"></i><span>category</span></button>
        <button class="cart-btn" title="Cartlist"><i
                class="fas fa-shopping-basket"></i><span>cartlist</span></button>
        {{-- <a href="wishlist.html" title="Wishlist"><i class="fas fa-heart"></i><span>wishlist</span><sup>0</sup></a>
        <a href="compare.html" title="Compare List"><i class="fas fa-random"></i><span>compare</span><sup>0</sup></a> --}}
    </div>
    {{ $slot }}
    <section class="intro-part">
        <div class="container">
            <div class="row intro-content">
                <div class="col-sm-6 col-lg-3">
                    <div class="intro-wrap">
                        <div class="intro-icon"><i class="fas fa-truck"></i></div>
                        <div class="intro-content">
                            <h5>free home delivery</h5>
                            <p>Lorem ipsum dolor sit amet adipisicing elit nobis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="intro-wrap">
                        <div class="intro-icon"><i class="fas fa-sync-alt"></i></div>
                        <div class="intro-content">
                            <h5>instant return policy</h5>
                            <p>Lorem ipsum dolor sit amet adipisicing elit nobis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="intro-wrap">
                        <div class="intro-icon"><i class="fas fa-headset"></i></div>
                        <div class="intro-content">
                            <h5>quick support system</h5>
                            <p>Lorem ipsum dolor sit amet adipisicing elit nobis.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="intro-wrap">
                        <div class="intro-icon"><i class="fas fa-lock"></i></div>
                        <div class="intro-content">
                            <h5>secure payment way</h5>
                            <p>Lorem ipsum dolor sit amet adipisicing elit nobis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer-part">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget"><a class="footer-logo" href="#"><img src="{{ asset_logo() }}"
                                alt="logo"></a>
                        <p class="footer-desc">Adipisci asperiores ipsum ipsa repellat consequatur repudiandae quisquam
                            assumenda dolor perspiciatis sit ipsum dolor amet.</p>
                        <ul class="footer-social">
                            <li><a class="icofont-facebook" href="#"></a></li>
                            <li><a class="icofont-twitter" href="#"></a></li>
                            <li><a class="icofont-linkedin" href="#"></a></li>
                            <li><a class="icofont-instagram" href="#"></a></li>
                            <li><a class="icofont-pinterest" href="#"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget contact">
                        <h3 class="footer-title">contact us</h3>
                        <ul class="footer-contact">
                            <li><i class="icofont-ui-email"></i>
                                <p><span>{{ config('app.email') }}</span></p>
                            </li>
                            <li><i class="icofont-ui-touch-phone"></i>
                                <p><span>{{ config('app.phone') }}</span></p>
                            </li>
                            <li><i class="icofont-location-pin"></i>
                                <p>{{ config('app.address') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget">
                        <h3 class="footer-title">quick Links</h3>
                        <div class="footer-links">
                            <ul>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order History</a></li>
                                <li><a href="#">Order Tracking</a></li>
                                <li><a href="#">Best Seller</a></li>
                                <li><a href="#">New Arrivals</a></li>
                            </ul>
                            <ul>
                                <li><a href="#">Location</a></li>
                                <li><a href="#">Affiliates</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">Carrer</a></li>
                                <li><a href="#">Faq</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="footer-widget">
                        <h3 class="footer-title">Download App</h3>
                        <p class="footer-desc"></p>
                        <div class="footer-app"><a href="#" target="_blank">
                                <img src="{{ asset('frontend/images/google-store.png') }}" alt="google"></a>
                            {{-- <a href="#"><img src="{{asset('frontend/images/app-store.png')}}" alt="app"></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p class="footer-copytext">&copy;{{ now()->format('Y') }} All Copyrights Reserved by <a
                                href="{{ config('app.url') }}">{{ config('app.name') }}.</a></p>
                        <div class="footer-card">
                            <a href="#"><img src="{{ asset('frontend/images/payment/jpg/01.jpg') }}"
                                    alt="payment"></a>
                            <a href="#"><img src="{{ asset('frontend/images/payment/jpg/02.jpg') }}"
                                    alt="payment"></a>
                            <a href="#"><img src="{{ asset('frontend/images/payment/jpg/03.jpg') }}"
                                    alt="payment"></a>
                            <a href="#"> <img src="{{ asset('frontend/images/payment/jpg/04.jpg') }}"
                                    alt="payment"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('frontend/vendor/bootstrap/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/countdown/countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/niceselect/nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/slickslider/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/nice-select.js') }}"></script>
    <script src="{{ asset('frontend/js/countdown.js') }}"></script>
    <script src="{{ asset('frontend/js/accordion.js') }}"></script>
    <script src="{{ asset('frontend/js/venobox.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::flash />

    <script>
        $(document).on('click', '.modalOpen', function() {
            Livewire.dispatch($(this).data('modal'), {
                data: $(this).data()
            })
        });

        window.addEventListener('modalOpen', event => {
            new window.bootstrap.Modal(document.getElementById(event.detail[0]), {
                backdrop: false
            }).show();
        });

        window.addEventListener('modalClose', event => {
            var modalInstance = window.bootstrap.Modal.getInstance(document.getElementById(event.detail[0]));

            if (modalInstance) {
                modalInstance.hide();
            } else {
                new window.bootstrap.Modal(modalElement, {
                    backdrop: false
                }).hide();
            }
        });

        window.addEventListener('callEventFunc', event => {
            Livewire.dispatch(event.detail.callName, {
                data: event.detail
            })
        });

        window.addEventListener('eventCallFunc', event => {
            Livewire.dispatch(event.detail.callName, {
                data: event.detail
            })
        });

        $(document).on('click', '.callEvent', function() {
            Livewire.dispatch($(this).data('listener'), {
                data: $(this).data()
            });
        });

        $(document).on("click", "[data-listener]", function(event) {
            var listener = $(this).data("listener");
            if (listener) {
                Livewire.dispatch(listener, {
                    data: $(this).data(),
                });
            }
        });
    </script>
    @stack('js')
</body>

</html>
