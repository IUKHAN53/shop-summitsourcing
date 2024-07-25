@extends('layouts.frontend')
@push('styles')
    <style>
        .form-input {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1;
        }
        .btn {
            padding: 0.5rem 1rem;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .btn-small {
            padding: 0.5rem;
        }
        .flex {
            display: flex;
        }
        .flex-row {
            flex-direction: row;
        }
        .items-center {
            align-items: center;
        }
        .mr-2 {
            margin-right: 0.5rem;
        }
    </style>
@endpush
@section('content')
    <main class="main">
        <div class="container mb-30">
            <div class="row">
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>Found <strong class="text-brand">{{ $products->total() }}</strong> items for Amazon
                                Trending Products</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class=" mr-10">
                                <form action="{{ route('pallet-products') }}" method="GET">
                                    <div class="flex flex-row items-center">
                                        <input type="text"  style="height: auto !important;" name="search" placeholder="Search products..." value="{{ request()->input('search') }}" class="form-input mr-2">
                                        <button type="submit" class="btn btn-small"><i class="fi-rs-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="sort-by-cover mr-10">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps"></i>Show:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>{{ $products->perPage() }} <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 15]) }}"
                                               class="{{ $products->perPage() == 15 ? 'active' : '' }}">15</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 25]) }}"
                                               class="{{ $products->perPage() == 25 ? 'active' : '' }}">25</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['pageSize' => 50]) }}"
                                               class="{{ $products->perPage() == 50 ? 'active' : '' }}">50</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>{{ $sort == 'asc' ? 'Price: Low to High' : ($sort == 'desc' ? 'Price: High to Low' : 'Featured') }}
                                            <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}"
                                               class="{{ $sort == 'default' ? 'active' : '' }}">Featured</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
                                               class="{{ $sort == 'asc' ? 'active' : '' }}">Price: Low to High</a></li>
                                        <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
                                               class="{{ $sort == 'desc' ? 'active' : '' }}">Price: High to Low</a></li>
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
                                            <a href="{{ route('product-detail', $product->offerId) }}">
                                                <img class="default-img" src="{{ $product->images }}" alt=""/>
                                                <img class="hover-img" src="{{ $product->images }}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a onclick="addToWishlist('{{ $product['offerId'] }}')"
                                               id="wishlist-{{ $product->offerId }}" aria-label="Add To Wishlist"
                                               class="action-btn" href="javascript:void(0)">
                                                @if(isWishlisted($product->offerId))
                                                    <img src="{{ asset('assets/heart-solid.svg') }}" alt="">
                                                @else
                                                    <i class="fi-rs-heart"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="#">{{ $product->category }}</a>
                                        </div>
                                        <h2>
                                            <a href="{{ route('product-detail', $product->offerId) }}">{{ $product->title }}</a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $product->width }}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $product->rating }})</span>
                                        </div>
                                        <div>
                                            <span class="font-small text-muted">Quantity {{ $product->quantity }}</span>
                                            | <span class="font-small text-muted">Sold {{ $product->sold }}</span>
                                            | <span class="font-small text-muted">Moq {{ $product->moq }}</span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>{{ convertCurrency($product->price) }}</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="#"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
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
                                @if ($products->currentPage() > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}"><i
                                                class="fi-rs-arrow-small-left"></i></a>
                                    </li>
                                @endif
                                @for ($i = 1; $i <= min($products->lastPage(), 10); $i++)
                                    <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                @if ($products->lastPage() > 10)
                                    <li class="page-item {{ $products->currentPage() > 10 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url(11) }}">...</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                                    </li>
                                @endif
                                @if ($products->currentPage() < $products->lastPage())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}"><i
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
