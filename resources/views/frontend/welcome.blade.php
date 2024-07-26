@extends('layouts.frontend')
@section('content')
    <main class="main">
        <section class="home-slider position-relative mb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 d-none d-lg-flex">
                        <div class="categories-dropdown-wrap style-2 font-heading mt-30">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="#">
                                                <img src="{{asset('assets/imgs/theme/icons/categories/'.$category->name.'.png')}}"
                                                     alt=""/>{{$category->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="home-slide-cover mt-30">
                            <div class="hero-slider-1 style-5 dot-style-1 dot-style-1-position-2">
                                <div class="single-hero-slider single-animation-wrap"
                                     style="background-image: url({{asset('assets/imgs/slider/s-0.jpg')}})">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40 text-white">
                                            One Stop Drop shipping <br/>
                                            Sourcing Assistant
                                        </h1>
                                    </div>
                                </div>
                                <div class="single-hero-slider single-animation-wrap"
                                     style="background-image: url({{asset('assets/imgs/slider/s-1.jpg')}})">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40 text-white">
                                            Don’t miss amazing<br/>
                                            deals
                                        </h1>
                                    </div>
                                </div>
                                <div class="single-hero-slider single-animation-wrap"
                                     style="background-image: url({{asset('assets/imgs/slider/s-3.jpg')}})">
                                    <div class="slider-content">
                                        <h1 class="display-2 mb-40 text-white">
                                            Don’t miss amazing<br/>
                                            deals
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-arrow hero-slider-1-arrow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End hero slider-->
        <section class="popular-categories section-padding">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Featured Categories</h3>
                    </div>
                    <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow"
                         id="carausel-10-columns-arrows"></div>
                </div>
                <div class="carausel-10-columns-cover position-relative">
                    <div class="carausel-10-columns" id="carausel-10-columns">
                        @foreach($categories as $category)
                            <div class="card-2 bg-9 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                                <figure class="img-hover-scale overflow-hidden">
                                    <a href=#"><img src="{{asset('assets/imgs/theme/icons/categories/'.$category->name.'.png')}}" alt=""/></a>
                                </figure>
                                <h6><a href="#">{{$category->name}}</a></h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>Amazon Trending products</h3>
                    <div class="more_categories">
                        <span class="icon"></span>
                        <a href="{{route('pallet-products')}}" class="float-end">
                            Show All
                        </a>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            @foreach($top_products as $product)
                                <div class="col-lg-1-5 col-md-4 col-6 col-sm-6 product-cart-wrap">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                         data-wow-delay=".1s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{route('product-detail',$product['offerId'])}}">
                                                    <img class="default-img" src="{{$product['images']}}"
                                                         alt="" loading="lazy"/>
                                                    <img class="hover-img" src="{{$product['images']}}"
                                                         alt="" loading="lazy"/>
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a onclick="addToWishlist('{{$product['offerId']}}')" id="wishlist-{{$product['offerId']}}"
                                                   aria-label="Add To Wishlist" class="action-btn"
                                                   href="javascript:void(0)">
                                                    @if(isWishlisted($product['offerId']))
                                                        <img src="{{asset('assets/heart-solid.svg')}}" alt="">
                                                    @else
                                                        <i class="fi-rs-heart"></i>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Trending</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">{{$product['category']}}</a>
                                            </div>
                                            <h2>
                                                <a href="{{ route('product-detail', $product['offerId']) }}">{{ shortenTitle($product['title']) }}...</a>                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating"
                                                         style="width: {{$product['width']}}%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{$product['rating']}}
                                                    )</span>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="current-price text-brand">{{convertCurrency($product['price'])}}</div>
                                                <div>
                                                    <span class="font-md color3">Minimum Order Quantity</span>
                                                    <span class="font-md ml-15">{{$product['moq']}}</span>
                                                </div>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="add-cart">
                                                    <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product-tabs section-padding position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>Amazon Best Selling products</h3>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                        <div class="row product-grid-4">
                            @foreach($best_selling_products as $product)
                                <div class="col-lg-1-5 col-md-4 col-6 col-sm-6 product-cart-wrap">
                                    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                         data-wow-delay=".1s">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{route('product-detail',$product['offerId'])}}">
                                                    <img class="default-img" src="{{$product['images']}}"
                                                         alt="" loading="lazy"/>
                                                    <img class="hover-img" src="{{$product['images']}}"
                                                         alt="" loading="lazy"/>
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a onclick="addToWishlist('{{$product['offerId']}}')" id="wishlist-{{$product['offerId']}}"
                                                   aria-label="Add To Wishlist" class="action-btn"
                                                   href="javascript:void(0)">
                                                    @if(isWishlisted($product['offerId']))
                                                        <img src="{{asset('assets/heart-solid.svg')}}" alt="">
                                                    @else
                                                        <i class="fi-rs-heart"></i>
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Trending</span>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="#">{{$product['category']}}</a>
                                            </div>
                                            <h2>
                                                <a href="{{ route('product-detail', $product['offerId']) }}">{{ shortenTitle($product['title']) }}...</a>                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating"
                                                         style="width: {{$product['width']}}%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> ({{$product['rating']}}
                                                    )</span>
                                            </div>
                                            <div class="flex flex-row">
                                                <div class="current-price text-brand">{{convertCurrency($product['price'])}}</div>
                                                <div>
                                                    <span class="font-md color3">Minimum Order Quantity</span>
                                                    <span class="font-md ml-15">{{$product['moq']}}</span>
                                                </div>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="add-cart">
                                                    <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
