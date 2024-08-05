@extends('layouts.frontend')
@section('content')
    <main class="main">
        <section class="popular-categories section-padding">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Categories</h3>
                    </div>
                </div>
                <div class="position-relative">
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-lg-1 col-md-2 col-sm-3 col-4">
                                <div class="card-2 bg-9 wow ">
                                    <figure class="img-hover-scale overflow-hidden">
                                        <a href="{{ route('cat-products', $category->id) }}">
                                            <img src="{{ $category->image }}" alt=""/>
                                        </a>
                                    </figure>
                                    <h6>
                                        <a href="{{ route('cat-products', $category->id) }}">{{ $category->name }}</a>
                                    </h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="pagination-area mt-20 mb-20">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            @if ($categories->currentPage() > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->previousPageUrl() }}">
                                        <i class="fi-rs-arrow-small-left"></i>
                                    </a>
                                </li>
                            @endif
                            @for ($i = 1; $i <= min($categories->lastPage(), 10); $i++)
                                <li class="page-item {{ $i == $categories->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $categories->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            @if ($categories->lastPage() > 10)
                                <li class="page-item {{ $categories->currentPage() > 10 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $categories->url(11) }}">...</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}">
                                        {{ $categories->lastPage() }}
                                    </a>
                                </li>
                            @endif
                            @if ($categories->currentPage() < $categories->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $categories->nextPageUrl() }}">
                                        <i class="fi-rs-arrow-small-right"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </main>
@endsection
