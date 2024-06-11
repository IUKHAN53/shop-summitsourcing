@extends('layouts.auth')
@section('content')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{route('welcome')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="assets/imgs/page/login-1.png" alt="" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Login</h1>
                                            <p class="mb-30">Don't have an account? <a href="{{route('register')}}">Create here</a></p>
                                        </div>
                                        <form method="post" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <div>
                                                    <x-input-label for="email" :value="__('Email')" />
                                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <x-input-label for="password" :value="__('Password')" />

                                                <x-text-input id="password" class="block mt-1 w-full"
                                                              type="password"
                                                              name="password"
                                                              required autocomplete="current-password" />

                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" name="remember" type="checkbox" id="exampleCheckbox1" value="" />
                                                        <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Log in</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
