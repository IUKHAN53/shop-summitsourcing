@extends('layouts.frontend')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('welcome')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        @livewire('components.product-detail', ['id' => $id])
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
{{--                            <div class="col-12">--}}
{{--                                <div class="row related-products">--}}
{{--                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">--}}
{{--                                        <div class="product-cart-wrap hover-up">--}}
{{--                                            <div class="product-img-action-wrap">--}}
{{--                                                <div class="product-img product-img-zoom">--}}
{{--                                                    <a href="shop-product-right.html" tabindex="0">--}}
{{--                                                        <img class="default-img" src="assets/imgs/shop/product-2-1.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                        <img class="hover-img" src="assets/imgs/shop/product-2-2.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-action-1">--}}
{{--                                                    <a aria-label="Quick view" class="action-btn small hover-up"--}}
{{--                                                       data-bs-toggle="modal" data-bs-target="#quickViewModal"><i--}}
{{--                                                            class="fi-rs-search"></i></a>--}}
{{--                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"--}}
{{--                                                       href="shop-wishlist.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-heart"></i></a>--}}
{{--                                                    <a aria-label="Compare" class="action-btn small hover-up"--}}
{{--                                                       href="shop-compare.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-shuffle"></i></a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-badges product-badges-position product-badges-mrg">--}}
{{--                                                    <span class="hot">Hot</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="product-content-wrap">--}}
{{--                                                <h2><a href="shop-product-right.html" tabindex="0">Ulstra Bass--}}
{{--                                                        Headphone</a></h2>--}}
{{--                                                <div class="rating-result" title="90%">--}}
{{--                                                    <span> </span>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-price">--}}
{{--                                                    <span>$238.85 </span>--}}
{{--                                                    <span class="old-price">$245.8</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">--}}
{{--                                        <div class="product-cart-wrap hover-up">--}}
{{--                                            <div class="product-img-action-wrap">--}}
{{--                                                <div class="product-img product-img-zoom">--}}
{{--                                                    <a href="shop-product-right.html" tabindex="0">--}}
{{--                                                        <img class="default-img" src="assets/imgs/shop/product-3-1.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                        <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-action-1">--}}
{{--                                                    <a aria-label="Quick view" class="action-btn small hover-up"--}}
{{--                                                       data-bs-toggle="modal" data-bs-target="#quickViewModal"><i--}}
{{--                                                            class="fi-rs-search"></i></a>--}}
{{--                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"--}}
{{--                                                       href="shop-wishlist.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-heart"></i></a>--}}
{{--                                                    <a aria-label="Compare" class="action-btn small hover-up"--}}
{{--                                                       href="shop-compare.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-shuffle"></i></a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-badges product-badges-position product-badges-mrg">--}}
{{--                                                    <span class="sale">-12%</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="product-content-wrap">--}}
{{--                                                <h2><a href="shop-product-right.html" tabindex="0">Smart Bluetooth--}}
{{--                                                        Speaker</a></h2>--}}
{{--                                                <div class="rating-result" title="90%">--}}
{{--                                                    <span> </span>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-price">--}}
{{--                                                    <span>$138.85 </span>--}}
{{--                                                    <span class="old-price">$145.8</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">--}}
{{--                                        <div class="product-cart-wrap hover-up">--}}
{{--                                            <div class="product-img-action-wrap">--}}
{{--                                                <div class="product-img product-img-zoom">--}}
{{--                                                    <a href="shop-product-right.html" tabindex="0">--}}
{{--                                                        <img class="default-img" src="assets/imgs/shop/product-4-1.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                        <img class="hover-img" src="assets/imgs/shop/product-4-2.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-action-1">--}}
{{--                                                    <a aria-label="Quick view" class="action-btn small hover-up"--}}
{{--                                                       data-bs-toggle="modal" data-bs-target="#quickViewModal"><i--}}
{{--                                                            class="fi-rs-search"></i></a>--}}
{{--                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"--}}
{{--                                                       href="shop-wishlist.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-heart"></i></a>--}}
{{--                                                    <a aria-label="Compare" class="action-btn small hover-up"--}}
{{--                                                       href="shop-compare.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-shuffle"></i></a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-badges product-badges-position product-badges-mrg">--}}
{{--                                                    <span class="new">New</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="product-content-wrap">--}}
{{--                                                <h2><a href="shop-product-right.html" tabindex="0">HomeSpeak 12UEA--}}
{{--                                                        Goole</a></h2>--}}
{{--                                                <div class="rating-result" title="90%">--}}
{{--                                                    <span> </span>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-price">--}}
{{--                                                    <span>$738.85 </span>--}}
{{--                                                    <span class="old-price">$1245.8</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6 d-lg-block d-none">--}}
{{--                                        <div class="product-cart-wrap hover-up mb-0">--}}
{{--                                            <div class="product-img-action-wrap">--}}
{{--                                                <div class="product-img product-img-zoom">--}}
{{--                                                    <a href="shop-product-right.html" tabindex="0">--}}
{{--                                                        <img class="default-img" src="assets/imgs/shop/product-5-1.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                        <img class="hover-img" src="assets/imgs/shop/product-3-2.jpg"--}}
{{--                                                             alt=""/>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-action-1">--}}
{{--                                                    <a aria-label="Quick view" class="action-btn small hover-up"--}}
{{--                                                       data-bs-toggle="modal" data-bs-target="#quickViewModal"><i--}}
{{--                                                            class="fi-rs-search"></i></a>--}}
{{--                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up"--}}
{{--                                                       href="shop-wishlist.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-heart"></i></a>--}}
{{--                                                    <a aria-label="Compare" class="action-btn small hover-up"--}}
{{--                                                       href="shop-compare.html" tabindex="0"><i--}}
{{--                                                            class="fi-rs-shuffle"></i></a>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-badges product-badges-position product-badges-mrg">--}}
{{--                                                    <span class="hot">Hot</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="product-content-wrap">--}}
{{--                                                <h2><a href="shop-product-right.html" tabindex="0">Dadua Camera 4K--}}
{{--                                                        2022EF</a></h2>--}}
{{--                                                <div class="rating-result" title="90%">--}}
{{--                                                    <span> </span>--}}
{{--                                                </div>--}}
{{--                                                <div class="product-price">--}}
{{--                                                    <span>$89.8 </span>--}}
{{--                                                    <span class="old-price">$98.8</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
