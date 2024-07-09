<?php
function getProductCategoryName($id) {
    return \App\Models\Category::query()->where('alibaba_id', $id)->first()->name ?? '';
}

function calculateWidth($score) {
    $totalScore = 5;
    return ($score / $totalScore) * 100;
}

function isWishlisted($product_id)
{
    $userId = auth()->id();
    return \App\Models\Wishlist::query()->where('user_id', $userId)->where('product_id', $product_id)->exists();
}

function getWishlistCount()
{
    $userId = auth()->id();
    return \App\Models\Wishlist::query()->where('user_id', $userId)->count();
}
