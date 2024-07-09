<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <title>SS ImportHub</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/imgs/logo.svg')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/plugins/animate.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/main.css?v=5.3')}}"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('styles')
</head>
<body>
@include('layouts.header')
@yield('content')
@include('layouts.footer')
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center">
                <img src="{{asset('assets/imgs/theme/loading.gif')}}" alt=""/>
            </div>
        </div>
    </div>
</div>
@stack('scripts')

<script>
    function addToWishlist(productId) {
        let product_div = $('#wishlist-' + productId);
        let wishlist_count_div = $('#wishlistCount');
        $.ajax({
            url: '/wishlist/toggle',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function (response) {
                if (response.action === 'added') {
                    product_div.html('<img src="{{asset('assets/heart-solid.svg')}}" alt="">');
                } else {
                    product_div.html('<i class="fi-rs-heart"></i>');
                }
                wishlist_count_div.text(response.wishlist_count);
            }
        });
    }
</script>

<script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/slick.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.syotimer.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/waypoints.js')}}"></script>
<script src="{{asset('assets/js/plugins/wow.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/js/plugins/magnific-popup.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/counterup.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.countdown.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/images-loaded.js')}}"></script>
<script src="{{asset('assets/js/plugins/isotope.js')}}"></script>
<script src="{{asset('assets/js/plugins/scrollup.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.vticker-min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.theia.sticky.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.elevatezoom.js')}}"></script>
<script src="{{asset('assets/js/main.js?v=5.3')}}"></script>
<script src="{{asset('assets/js/shop.js?v=5.3')}}"></script>
</body>
</html>
