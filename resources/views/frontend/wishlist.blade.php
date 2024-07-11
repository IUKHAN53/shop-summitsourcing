@extends('layouts.frontend')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('welcome')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span> Wishlist</span>
                </div>
            </div>
        </div>
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand">{{count($wishlist)}}</span> products in
                            this list</h6>
                    </div>
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                            <tr class="main-heading">
                                <th class="start pl-30" colspan="2">
                                    Product
                                </th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock Status</th>
                                <th scope="col">Action</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($wishlist as $item)
                                <tr>
                                    <td class="pl-30 ">
                                        <img src="{{$item['images'][0]}}" alt="#">
                                    </td>
                                    <td class="product-des product-name">
                                        <h6><a class="product-name mb-10"
                                               href="{{route('product-detail', $item['item_id'])}}">{{$item['title']}}</a>
                                        </h6>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{$item['width']}}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{$item['rating']}})</span>
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h3 class="text-brand">{{convertCurrency($item['price'])}}</h3>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <span
                                            class="stock-status in-stock mb-0"> {{ $item['quantity'] - $item['sold'] > 0 ? 'In Stock' : 'Out of Stock' }} </span>
                                    </td>
                                    <td class="text-right" data-title="Cart">
                                        <button class="btn btn-sm">Add to cart</button>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="{{route('wishlist.remove',$item['id'])}}" class="text-body"><i
                                                class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
