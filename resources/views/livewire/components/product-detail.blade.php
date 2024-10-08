<div>
    <div class="row mb-50 mt-30">
        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
            <div class="detail-gallery" wire:ignore>
                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                <div class="product-image-slider">
                    @foreach($product['images'] as $image)
                        <figure class="border-radius-10">
                            <img src="{{$image}}" alt="product image"/>
                        </figure>
                    @endforeach
                </div>
                <div class="slider-nav-thumbnails">
                    @foreach($product['images'] as $image)
                        <div><img src="{{$image}}" alt="product image"/></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-info pr-30 pl-30">
                <h2 class="title-detail">{{$product['title']}}</h2>
                <div class="product-detail-rating">
                    <div class="product-rate-cover text-end">
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: {{$product['width']}}%"></div>
                        </div>
                        <span class="font-small ml-5 text-muted"> ({{$product['rating']}})</span>
                    </div>
                </div>
                <div class="clearfix product-price-cover">
                    <div class="product-price primary-color float-left">
                        <span
                            class="current-price text-brand">{{convertCurrency($selectedSku['price'] ?? $price)}}</span>
                        <span>
                            <span class="font-md ml-15">{{$selectedSku['amountOnSale'] ?? $product['moq']}}</span>
                            <span class="font-md color3 ml-15">In Stock</span>
                        </span>
                    </div>
                </div>

                <div>
                    @foreach($sku_groups as $rootName => $group)
                        <div class="attr-detail attr-size mb-30">
                            <strong class="mr-10">{{ $rootName }}: </strong>
                            <ul class="list-filter size-filter font-small">
                                @foreach($group as $value => $details)
                                    <li class="{{ isset($selectedAttributes[$rootName]) && $selectedAttributes[$rootName] === $value ? 'active' : '' }}">
                                        <a href="#"
                                           wire:click.prevent="resetAndSelectAttribute('{{ $rootName }}', '{{ $value }}')">
                                            {{ $value }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @break
                    @endforeach

                    @foreach($attributeStack as $index => $groupInfo)
                        @if(!empty($groupInfo['group']))
                            <div class="attr-detail attr-size mb-30">
                                @php
                                    $attributeName = array_keys($groupInfo['group'])[0];
                                @endphp
                                <strong class="mr-10">{{ $attributeName }}: </strong>
                                <ul class="list-filter size-filter font-small">
                                    @foreach($groupInfo['group'] as $name => $group)
                                        @foreach($group as $value => $details)
                                            <li class="{{ isset($selectedAttributes[$name]) && $selectedAttributes[$name] === $value ? 'active' : '' }}">
                                                <a href="#"
                                                   wire:click.prevent="selectAttribute('{{ $name }}', '{{ $value }}')">
                                                    {{ $value }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>


                <div class="detail-extralink mb-50">
                    <div class="detail-qty border radius">
                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                        <input type="text" name="quantity" class="qty-val" value="1" min="1">
                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                    </div>
                    <div class="product-extra-link2">
                        <button type="submit" class="button button-add-to-cart"><i
                                class="fi-rs-shopping-cart"></i>Add to cart
                        </button>
                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i
                                class="fi-rs-heart"></i></a>
                    </div>
                </div>
                <div class="font-xs">
                    <div class="d-flex">
                        <ul class="mr-50 flex-fill">
                            @foreach($product_attributes as $name => $value)
                                <li class="mb-5">{{ $name }}:
                                    <span class="text-brand">
                                        {{ is_numeric($value) ? number_format(floatval($value), 2) : $value }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        @if(isset($selected_sku))
                            <ul class="mr-50 flex-fill">
                                @foreach($product['dropshipping_info'] as $name => $value)
                                    @if(is_array($value))
                                        @continue
                                    @else
                                        <li class="mb-5">{{ $name }}:
                                            <span class="text-brand">
                                                {{ is_numeric($value) ? number_format(floatval($value), 2) : $value }}
                                                @if(in_array($name, ['width', 'height', 'length']))
                                                    cm
                                                @endif
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-info">
        <div class="tab-style3">
            <ul class="nav nav-tabs text-uppercase">
                <li class="nav-item">
                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                       href="#Description">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                       href="#Vendor-info">Seller Scores</a>
                </li>
            </ul>
            <div class="tab-content shop_info_tab entry-main-content">
                <div class="tab-pane fade show active" id="Description">
                    {!! $product['description'] !!}
                </div>
                <div class="tab-pane fade" id="Vendor-info">
                    <div class="d-flex mb-55">
                        @foreach($product['seller_info'] as $name => $value)
                            <div class="mr-30">
                                <p class="text-brand font-xs">{{$name}}</p>
                                <h4 class="mb-0">{{$value}}%</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
