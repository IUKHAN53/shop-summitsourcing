<header class="header-area header-style-1 header-style-5 header-height-2">
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1 ">
                    <a href="{{route('welcome')}}">
                        <img src="{{asset('assets/imgs/logo.svg')}}" alt="logo" width="120" height="100"/>
                    </a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form id="searchForm" action="{{ route('search-products') }}" method="post" style="max-width: 660px" class="search-form" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="search" name="search" id="searchInput" placeholder="Search for items by keyword or image" class="form-control"/>
                                <label class="input-group-text" for="inputGroupFile" style="background-color: #ffff; border: none; margin-bottom: 0 !important; padding: 0 !important;">
                                    <i class="fas fa-camera" style="color: #3bb77e;"></i>
                                </label>
                                <input type="file" name="image" class="form-control" id="inputGroupFile" style="display:none;" onchange="handleFileUpload()">
                            </div>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="search-location">
                                <form action="{{ route('setCurrency') }}" method="POST">
                                    @csrf
                                    <select name="currency" class="select-active" onchange="this.form.submit()">
                                        <option value="USD" {{session('currency') == 'USD' ? 'selected' : ''}}>USD
                                        </option>
                                        <option value="CNY" {{session('currency') == 'CNY' ? 'selected' : ''}}>CNY
                                        </option>
                                        <option value="EUR" {{session('currency') == 'EUR' ? 'selected' : ''}}>EUR
                                        </option>
                                        <option value="GBP" {{session('currency') == 'GBP' ? 'selected' : ''}}>GBP
                                        </option>
                                        <option value="PKR" {{session('currency') == 'PKR' ? 'selected' : ''}}>PKR
                                        </option>
                                        <option value="NZD" {{session('currency') == 'NZD' ? 'selected' : ''}}>NZD
                                        </option>
                                        <option value="AUD" {{session('currency') == 'AUD' ? 'selected' : ''}}>AUD
                                        </option>
                                        <option value="INR" {{session('currency') == 'INR' ? 'selected' : ''}}>INR
                                        </option>
                                    </select>
                                </form>
                            </div>
                            <div class="header-action-icon-2">
                                <a href="#">
                                    <img class="svgInject" alt="Nest"
                                         src="{{asset('assets/imgs/theme/icons/icon-heart.svg')}}"/>
                                    <span class="pro-count blue" id="wishlistCount">{{getWishlistCount()}}</span>
                                </a>
                                <a href="{{route('wishlist.index')}}"><span class="lable">Wishlist</span></a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="Nest" src="{{asset('assets/imgs/theme/icons/icon-cart.svg')}}"/>
                                    {{--                                    <span class="pro-count blue">2</span>--}}
                                </a>
                                <a href="#"><span class="lable">Cart</span></a>
                            </div>
                            <div class="header-action-icon-2">
                                @auth
                                    <a href="page-account.html">
                                        <img class="svgInject" alt="Nest"
                                             src="{{asset('assets/imgs/theme/icons/icon-user.svg')}}"/>
                                    </a>
                                    <a href="page-account.html"><span class="lable ml-0">Account</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li>
                                                <a href="page-account.html"><i class="fi fi-rs-user mr-10"></i>My
                                                    Account</a>
                                            </li>
                                            <li>
                                                <a href="page-account.html"><i class="fi fi-rs-location-alt mr-10"></i>Order
                                                    Tracking</a>
                                            </li>
                                            <li>
                                                <a href="page-account.html"><i class="fi fi-rs-label mr-10"></i>My
                                                    Voucher</a>
                                            </li>
                                            <li>
                                                <a href="{{route('wishlist.index')}}"><i
                                                        class="fi fi-rs-heart mr-10"></i>My
                                                    Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="page-account.html"><i
                                                        class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                            </li>
                                            <li>
                                                <form action="{{route('logout')}}" id="logout_form" method="POST">
                                                    @csrf
                                                </form>
                                                <a onclick="document.getElementById('logout_form').submit()" href="#">
                                                    <i class="fi fi-rs-sign-out mr-10"></i>
                                                    Sign out
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{route('login')}}">
                                        <img class="svgInject" alt="Nest"
                                             src="{{asset('assets/imgs/theme/icons/icon-user.svg')}}"/>
                                    </a>
                                    <a href="{{route('login')}}"><span class="lable ml-0">Login</span></a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'register' && Route::currentRouteName() != 'login')
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="#"><img src="{{asset('assets/imgs/logo.svg')}}" alt="logo"/></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li class="hot-deals">
                                        <a href="{{route('welcome')}}">Home</a>
                                    </li>
                                    <li class="hot-deals">
                                        <a href="#">Categories</a>
                                    </li>
                                    <li class="hot-deals">
                                        <a href="{{route('static-page','dropshipping')}}">Dropshipping</a>
                                    </li>
                                    <li class="hot-deals">
                                        <a href="{{route('static-page','services')}}">Our Services</a>
                                    </li>
                                    <li class="hot-deals">
                                        <a href="{{route('static-page','about_us')}}">About Us</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{route('wishlist.index')}}">
                                    <img alt="Nest" src="{{asset('assets/imgs/theme/icons/icon-heart.svg')}}"/>
                                    <span class="pro-count white wishlistCount">0</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="Nest" src="{{asset('assets/imgs/theme/icons/icon-cart.svg')}}"/>
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="#">
                                                    <img alt="Nest"
                                                         src="{{asset('assets/imgs/shop/thumbnail-3.jpg')}}"/>
                                                </a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="#">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html">
                                                    <img alt="Nest"
                                                         src="{{asset('assets/imgs/shop/thumbnail-4.jpg')}}"/>
                                                </a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-search search-style-3 custom-search mobile-header-border">
                <form action="{{route('search-products')}}" method="get">
                    <input type="text" name="search" placeholder="Search for items..."/>
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
        </div>
    @endif
</header>
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{route('welcome')}}"><img src="{{asset('assets/imgs/logo.svg')}}" alt="logo" width="80"
                                                    height="80"/></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li><a href="{{route('welcome')}}">Home</a></li>
                        <li><a href="#">Categories</a></li>
                        <li><a href="{{route('static-page','dropshipping')}}">Dropshipping</a></li>
                        <li><a href="{{route('static-page','services')}}">Our Services</a></li>
                        <li><a href="{{route('static-page','about_us')}}">About Us</a></li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="https://maps.app.goo.gl/UwZHiQPR54KAncj19" target="_blank"><i class="fi-rs-marker"></i> Our
                        location </a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{route('login')}}"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="https://www.facebook.com/Summitsourcingchina" target="_blank"><img
                        src="{{asset('assets/imgs/theme/icons/icon-facebook-white.svg')}}" alt=""/></a>
                <a href="https://www.tiktok.com/@summit.sourcing.china" target="_blank"><img
                        src="{{asset('assets/imgs/theme/icons/tiktok.svg')}}" alt=""/></a>
                <a href="https://www.instagram.com/summitsourcing/" target="_blank"><img
                        src="{{asset('assets/imgs/theme/icons/icon-instagram-white.svg')}}" alt=""/></a>
                <a href="https://wa.link/summitsourcing" target="_blank"><img
                        src="{{asset('assets/imgs/theme/icons/whatsapp.svg')}}" alt=""/></a>
                <a href="https://www.linkedin.com/company/guangzhousummitsourcing" target="_blank"><img
                        src="{{asset('assets/imgs/theme/icons/linkedin.svg')}}" alt=""/></a>
            </div>
            <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
        </div>
    </div>
</div>
