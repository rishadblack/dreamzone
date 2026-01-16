<html lang="en" dir="ltr" data-header-style="light" data-menu-style="dark" data-theme-color="light"
    style="--primary-bg-color-rgb: 244, 166, 167;" data-width="fullwidth" data-position="fixed" data-logo="defaultlogo"
    data-skins="shadow" data-layout="vertical" data-vertical-style="icontext">
{{-- <html lang="en" dir="ltr" data-header-style="light" data-menu-style="light" data-theme-color="light"
    style="--primary-bg-color-rgb: 244, 166, 167; --primary-bg-color-rgb: #00ad57ab;" data-theme-color="light"
    data-width="fullwidth" data-position="fixed" data-logo="defaultlogo" data-skins="shadow" data-layout="vertical"
    data-vertical-style="icontext"> --}}

<head>
    <!-- Meta data -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta
        content="@isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}"
        name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <meta name="keywords"
        content="@isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}" />

    <!--favicon -->
    <link rel="icon" href="{{ asset('backend/images/brand/favicon.ico') }}" type="image/x-icon" />

    <!-- TITLE -->
    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}
    </title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLES CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" />

    <!-- PLUGIN CSS -->
    <link href="{{ asset('backend/css/plugin.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet" />

    <!-- Switcher css -->
    <link href="{{ asset('backend/switcher/css/switcher.css') }}" rel="stylesheet" id="switcher-css" type="text/css"
        media="all" />
    <link href="{{ asset('backend/switcher/demo.css') }}" rel="stylesheet" />

    @livewireStyles
    @livewireScripts
    @vite(['resources/sass/backend.scss', 'resources/js/backend.js'])
    <style>
        .page-header {
            margin-block: 0.5rem;
        }

        .form-control {
            color: var(--black-7);
        }

        table,
        tr,
        th {
            border: 0.5px solid #474747;
        }

        .dropdown-toggle {
            color: #fff;
        }

        .input-group {
            width: auto;
        }
    </style>
    @stack('css')
    <style>
        .input-group {
            width: auto;
        }
    </style>
</head>

<body class="sidebar-mini2 app sidebar-mini">
    <div class="page">
        <div class="page-main">
            <div>
                <!-- START HEADER -->
                <div class="app-header sticky" style="margin-bottom: -65px;">
                    <div class="main-container container-fluid d-flex">
                        <div class="d-flex header-left">
                            <div class="responsive-logo">
                                <a class="main-logo" href="{{ route('backend.dashboard') }}">
                                    <img src="{{ asset_logo() }}" class="desktop-logo desktop-logo-dark"
                                        alt="{{ config('app.name') }}" />
                                    <img src="{{ asset_logo() }}" class="desktop-logo"
                                        alt="{{ config('app.name') }}" />
                                </a>
                            </div>
                            <div class="header-nav-link">
                                <a href="javascript:void(0);" data-bs-toggle="sidebar"
                                    class="nav-link icon toggle app-sidebar__toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"></path>
                                    </svg>
                                </a>
                            </div>
                            <!-- language -->
                        </div>
                        <div class="d-flex header-right ms-auto">
                            <div class="header-nav-link">
                                <a href="javascript:void(0);" class="nav-link icon d-lg-none" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path
                                            d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            <div class="responsive-navbar align-items-stretch navbar-expand-lg navbar-light p-0 mb-0">
                                <div class="collapse align-items-stretch navbar-collapse" id="navbarSupportedContent-4">
                                    <ul class="list-unstyled nav">
                                        <li class="header-nav-link header-fullscreen">
                                            <a href="javascript:void(0);" class="nav-link icon" id="fullscreen-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M10 4H8v4H4v2h6zM8 20h2v-6H4v2h4zm12-6h-6v6h2v-4h4zm0-6h-4V4h-2v6h6z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </li>
                                        <!-- Fullscreen -->

                                        {{-- <li class="header-nav-link">
                                            <a href="javascript:void(0);"
                                                class="nav-link icon layout-setting light-layout">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="nav-link icon layout-setting light-layout">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </li> --}}
                                        <!-- theme-layout -->

                                        <li class="header-nav-link dropdown">
                                            <a href="javascript:void(0);" class="nav-link icon text-center"
                                                data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z">
                                                    </path>
                                                </svg>
                                                <span class="pulse bg-success"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="d-flex">
                                                        <h5 class="mb-0 text-light">Notifications</h5>
                                                        <span class="badge bg-danger ms-auto br-5">0</span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider mt-0"></div>
                                                {{-- <div class="header-dropdown-scroll1">
                                                    <a href="emailinbox.html" class="dropdown-item d-flex">
                                                        <div class="notifyimg bg-success-transparent">
                                                            <i class="fa fa-thumbs-o-up text-success"></i>
                                                        </div>
                                                        <div>
                                                            <strong>Someone likes our posts.</strong>
                                                            <div class="small text-muted">3 hours ago</div>
                                                        </div>
                                                    </a>
                                                </div> --}}
                                                <div class="dropdown-divider mb-0"></div>
                                                <div class="text-center p-2">
                                                    <a href="#" class="text-light pt-0">View All
                                                        Notifications</a>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- Notification -->

                                        <li class="header-nav-link dropdown">
                                            <a href="javascript:void(0);" class="nav-link icon"
                                                data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16 2H8C4.691 2 2 4.691 2 8v13a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 14c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v8z">
                                                    </path>
                                                    <path d="M7 9h10v2H7zm0 4h7v2H7z"></path>
                                                </svg>
                                                <span class="badge badge-secondary pulse-secondary">0</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="d-flex">
                                                        <h5 class="mb-0 text-light">Messages</h5>
                                                        <span class="badge bg-danger ms-auto br-5">0</span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider mt-0"></div>
                                                {{-- <div class="header-dropdown-scroll2">
                                                    <a href="chat.html" class="dropdown-item d-flex mt-2 pb-3">
                                                        <div class="avatar avatar-md rounded-circle me-3 d-block cover-image"
                                                            data-image-src="{{ auth()->user()->profile_url }}">
                                                            <span class="avatar-status bg-green"></span>
                                                        </div>
                                                        <div>
                                                            <strong>Madeleine</strong>
                                                            <p class="mb-0 fs-13 text-muted">
                                                                Hey! there I' am available
                                                            </p>
                                                            <div class="small text-muted">3 hours ago</div>
                                                        </div>
                                                    </a>
                                                </div> --}}
                                                <div class="dropdown-divider mb-0"></div>
                                                <div class="text-center p-2">
                                                    <a href="#" class="text-light pt-0">View All Messages</a>
                                                </div>
                                            </div>
                                        </li>
                                        <!-- Message-box -->

                                        <li class="header-nav-link dropdown">
                                            <a href="javascript:void(0);" class="nav-link icon"
                                                data-bs-toggle="dropdown">
                                                <img class="avatar rounded-circle"
                                                    src="{{ auth()->user()->profile_url }}" alt="image" />
                                            </a>
                                            <ul
                                                class="dropdown-menu w-250 pt-0 dropdown-menu-arrow dropdown-menu-right">
                                                <li>
                                                    <div class="dropdown-header mb-2 p-3 text-center">
                                                        <img class="avatar avatar-xl rounded-circle mx-auto mb-2"
                                                            src="{{ auth()->user()->profile_url }}" alt="image" />
                                                        <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                                        <p class="mb-0 fs-13 opacity-75">
                                                            {{ auth()->user()->username }}
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="{{ route('backend.profile') }}"
                                                        class="dropdown-item d-flex align-items-center" wire:navigate>
                                                        <i class="ri-user-line fs-18 me-2 text-primary"></i>
                                                        <span>Profile</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('backend.kyc') }}"
                                                        class="dropdown-item d-flex align-items-center" wire:navigate>
                                                        <i class="ri-settings-5-line fs-18 me-2 text-primary"></i>
                                                        <span>Kyc</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('frontend.contact') }}"
                                                        class="dropdown-item d-flex aligni-tems-center">
                                                        <i class="ri-question-line fs-18 me-2 text-primary"></i>
                                                        <span>Need help?</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <livewire:backend.components.logout />
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END HEADER -->
                <!-- START LEFT-SIDEBAR-MENU -->
                <div class="sticky">
                    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                    <aside class="app-sidebar" style="--menu-bg: #00a652">
                        <div class="app-sidebar__header">
                            <a class="main-logo" wire:navigate href="{{ route('backend.dashboard') }}">
                                <img src="{{ asset_logo() }}" class="desktop-logo desktop-logo-dark"
                                    alt="{{ config('app.name') }}" />
                                <img src="{{ asset_logo() }}" style="height:60px ;width:170px;"
                                    class="desktop-logo" alt="{{ config('app.name') }}" />
                            </a>
                        </div>
                        <div class="main-sidemenu">
                            <div class="slide-left disabled" id="slide-left">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z">
                                    </path>
                                </svg>
                            </div>
                            {{-- @persist('menu') --}}
                            <ul class="side-menu">
                                <li class="sub-category">
                                    <h3>Main</h3>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.dashboard') }}">
                                        <span class="side-menu__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="side_menu_img"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="side-menu__label text-truncate">Dashboard</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.withdrawal') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-upload" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Payout</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.balance') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-send" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Manage Wallet</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.deposit') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-download" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Deposit</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.member_list') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-users" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">My Team</span>
                                    </a>
                                </li>
                                {{-- <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.package_list') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-server" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Packages</span>
                                    </a>
                                </li> --}}
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('backend.upgrade_list') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-server" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Upgrade</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('ecommerce.shop') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-server" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Shop</span>
                                    </a>
                                </li>
                                {{-- <li class="slide">
                                    <a class="side-menu__item" href="{{ route('ecommerce.order_list') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-server" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Order List</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{ route('ecommerce.dealer_delivery_list') }}">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-server" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Order Delivery</span>
                                    </a>
                                </li> --}}
                                <li class="slide">
                                    <a class="side-menu__item " data-bs-toggle="slide" href="javascript:void(0);">
                                        <span class="side-menu__icon">
                                            <i class="fe fe-activity" aria-hidden="true"></i>
                                        </span>
                                        <span class="side-menu__label text-truncate">Report</span>
                                        <i class="angle fa fa-angle-right"></i>
                                    </a>
                                    <ul class="slide-menu">
                                        <li>
                                            <a class="slide-item" href="{{ route('backend.report.sponsor') }}"> Refer
                                                List</a>
                                            <a class="slide-item"
                                                href="{{ route('backend.report.sponsor_income') }}">
                                                Refer Commission</a>
                                            <a class="slide-item"
                                                href="{{ route('backend.report.generation_income') }}">
                                                Team Commission</a>
                                            <a class="slide-item" href="{{ route('backend.report.roi_income') }}">
                                                Honorarium</a>
                                            <a class="slide-item"
                                                href="{{ route('backend.report.incentive_income') }}">
                                                Incentives</a>
                                            <a class="slide-item" href="{{ route('backend.report.balance') }}">
                                                Balance List
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @hasanyrole('superadmin|admin|manager')
                                    <li class="slide">
                                        <a class="side-menu__item " data-bs-toggle="slide" href="javascript:void(0);">
                                            <span class="side-menu__icon">
                                                <i class="fe fe-activity" aria-hidden="true"></i>
                                            </span>
                                            <span class="side-menu__label text-truncate">Superadmin</span>
                                            <i class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu">
                                            <li>
                                                <a href="{{ route('superadmin.dashboard') }}"
                                                    class="slide-item">Dashboard</a>
                                                <a href="{{ route('superadmin.settings') }}"
                                                    class="slide-item">Settings</a>
                                                <a href="{{ route('superadmin.member_list') }}" class="slide-item">Member
                                                    List</a>
                                                <a href="{{ route('superadmin.balance_generate') }}"
                                                    class="slide-item">Generate Balance</a>
                                                <a href="{{ route('superadmin.statement_list') }}"
                                                    class="slide-item">Statement List</a>
                                                <a href="{{ route('superadmin.deposit_list') }}"
                                                    class="slide-item">Deposit Received</a>
                                                <a href="{{ route('superadmin.withdraw_pay') }}"
                                                    class="slide-item">Withdrawal Pay</a>
                                                <a href="{{ route('superadmin.achievement_list') }}"
                                                    class="slide-item">Achievers</a>
                                                <a href="{{ route('superadmin.package_list') }}"
                                                    class="slide-item">Package</a>
                                                <a href="{{ route('superadmin.point_list') }}"
                                                    class="slide-item">Points</a>
                                                <a href="{{ route('superadmin.income_list') }}" class="slide-item">Income
                                                    Report</a>
                                                <a href="{{ route('superadmin.withdrawal_list') }}"
                                                    class="slide-item">Withdrawal Report</a>
                                                <a href="{{ route('superadmin.balance_list') }}"
                                                    class="slide-item">Balance Report</a>
                                                <a href="{{ route('superadmin.member_history') }}"
                                                    class="slide-item">Member Report</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endhasanyrole
                                @hasanyrole('superadmin|admin|manager')
                                    <li class="slide">
                                        <a class="side-menu__item " data-bs-toggle="slide" href="javascript:void(0);">
                                            <span class="side-menu__icon">
                                                <i class="fe fe-activity" aria-hidden="true"></i>
                                            </span>
                                            <span class="side-menu__label text-truncate">Ecommerce</span>
                                            <i class="angle fa fa-angle-right"></i>
                                        </a>
                                        <ul class="slide-menu">
                                            <li>
                                                <a href="{{ route('ecommerce.admin.dashboard') }}"
                                                    class="slide-item">Dashboard</a>
                                                <a href="{{ route('ecommerce.admin.product_list') }}"
                                                    class="slide-item">Product List</a>
                                                <a href="{{ route('ecommerce.admin.category_list') }}"
                                                    class="slide-item">Category List</a>
                                                <a href="{{ route('ecommerce.admin.brand_list') }}"
                                                    class="slide-item">Brand List</a>
                                                <a href="{{ route('ecommerce.admin.dealer_list') }}"
                                                    class="slide-item">Dealer List</a>
                                                <a href="{{ route('ecommerce.admin.order_delivery_list') }}"
                                                    class="slide-item">Order Delivery</a>
                                                <a href="{{ route('ecommerce.admin.inventory_list') }}"
                                                    class="slide-item">Inventory</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endhasanyrole
                            </ul>
                            {{-- @endpersist --}}
                            <div class="slide-right" id="slide-right">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </aside>
                </div>
                <!-- END LEFT-SIDEBAR-MENU -->
            </div>

            <!-- START APP-CONTENT -->
            <div class="main-content app-content">
                @isset($header)
                    <!-- START PAGE-HEADER -->
                    <div class="page-header main-container container-fluid px-5">
                        <h4 class="page-title">
                            {{ $header }}
                        </h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $header }}
                            </li>
                        </ol>
                    </div>
                    <!-- END PAGE-HEADER -->
                @endisset

                <!-- START MAIN-CONTAINER -->
                <div class="main-container container-fluid">
                    {{ $slot }}
                </div>
                <!-- END MAIN-CONTAINER -->
            </div>
            <!-- END APP-CONTENT -->
        </div>

        <!-- START FOOTER -->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center">
                        Copyright © {{ now()->format('Y') }} <a href="#">{{ config('app.name') }}</a> All
                        rights reserved.
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER -->
    </div>
    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-level-up"></i></a>

    <!-- JQUERY SCRIPTS -->
    <script src="{{ asset('backend/js/vendors/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ asset('backend/plugins/bootstrap/js/popper.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.min.js') }}"></script> --}}

    <!-- STICKY JS-->
    <script src="{{ asset('backend/js/sticky.js') }}?v={{ now() }}"></script>

    <!-- SIDEMENU JS-->
    <script src="{{ asset('backend/plugins/sidemenu/sidemenu.js') }}?v={{ now() }}" data-navigate-track></script>

    <!-- PERFECT SCROLL BAR JS-->
    {{-- <script src="{{ asset('backend/plugins/pscrollbar/perfect-scrollbar.js') }}"></script> --}}
    {{-- <script src="{{ asset('backend/plugins/pscrollbar/pscroll-sidemenu.js') }}"></script> --}}

    <!-- SIDEBAR JS -->
    <script src="{{ asset('backend/plugins/sidebar/sidebar.js') }}?v={{ now() }}"></script>

    <!-- CUSTOM-SWICTHER JS -->
    <script src="{{ asset('backend/js/custom-switcher.js') }}?v={{ now() }}" data-navigate-track></script>

    <!-- SWITCHER JS -->
    <script src="{{ asset('backend/switcher/js/switcher.js') }}?v={{ now() }}"></script>

    <!-- CUSTOM JS-->
    <script src="{{ asset('backend/js/custom.js') }}?v={{ now() }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" data-navigate-once></script>
    @livewireScriptConfig
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" data-navigate-once></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@2.29.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
    </script>
    @stack('js')
</body>

</html>
