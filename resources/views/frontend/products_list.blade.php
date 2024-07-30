@extends('layouts.frontend')
@section('content')
    <main class="main">
        <div class="container mb-30">
            <div class="row">
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>Found <strong class="text-brand">{{$total_records}}</strong> items for your search!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>{{ $pageSize }} <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 15]) }}"
                                               class="{{ $pageSize == 15 ? 'active' : '' }}">15</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 25]) }}"
                                               class="{{ $pageSize == 25 ? 'active' : '' }}">25</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 50]) }}"
                                               class="{{ $pageSize == 50 ? 'active' : '' }}">50</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>
                                            {{ $sort == 'asc' ? 'Price: Low to High' : ($sort == 'desc' ? 'Price: High to Low' : 'Featured' ) }}
                                            <i class="fi-rs-angle-small-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}"
                                               class="{{ $sort == 'default' ? 'active' : '' }}">Featured</a>
                                        </li>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
                                               class="{{ $sort == 'asc' ? 'active' : '' }}">Price: Low to High</a>
                                        </li>
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
                                               class="{{ $sort == 'desc' ? 'active' : '' }}">Price: High to Low</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">
                        @foreach($products as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{route('product-detail',$product['offerId'])}}">
                                                <img loading="lazy"  class="default-img" src="{{$product['imageUrl']}}" alt=""/>
                                                <img loading="lazy"  class="hover-img" src="{{$product['imageUrl']}}" alt=""/>
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
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#">{{isset($product['topCategoryId']) ? getProductCategoryName($product['topCategoryId']):''}}</a>
                                        </div>
                                        <h2>
                                            <a href="{{route('product-detail',$product['offerId'])}}">{{$product['subjectTrans']}}</a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{$product['tradeScore']}}
                                                )</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">By <a
                                                    href="#">{{implode(',', $product['sellerIdentities'])}}</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>{{convertCurrency($product['priceInfo']['price'])}}</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="shop-cart.html"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                @if ($page > 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"><i
                                                class="fi-rs-arrow-small-left"></i></a>
                                    </li>
                                @endif
                                @for ($i = 1; $i <= min($pages, 10); $i++)
                                    <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                        <a class="page-link"
                                           href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                @if ($pages > 10)
                                    <li class="page-item {{ $page > 10 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 11]) }}">...</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ request()->fullUrlWithQuery(['page' => $pages]) }}">{{ $pages }}</a>
                                    </li>
                                @endif
                                @if ($page < $pages)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"><i
                                                class="fi-rs-arrow-small-right"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
