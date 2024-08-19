<?php

use App\Models\ExchangeRate;

function getProductCategoryName($id)
{
    return \App\Models\Category::query()->where('alibaba_id', $id)->first()->name ?? '';
}

function calculateWidth($score)
{
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

if (!function_exists('convertCurrency')) {
    function convertCurrency($amount)
    {
        $currency = session('currency', 'USD');
        $rate = ExchangeRate::where('currency', $currency)->value('rate');

        if (!$rate) {
            throw new Exception('Currency rate not found');
        }

        $convertedAmount = $amount * $rate;
        return formatCurrency($convertedAmount, $currency);
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $currency): string
    {
        return match ($currency) {
            'USD' => '$' . number_format($amount, 2),
            'EUR' => '€' . number_format($amount, 2),
            'CNY' => '¥' . number_format($amount, 2),
            'AED' => 'AED ' . number_format($amount, 2),
            'GBP' => '£' . number_format($amount, 2),
            'PKR' => '₨' . number_format($amount, 2),
            'NZD' => 'NZ$' . number_format($amount, 2),
            'AUD' => 'AU$' . number_format($amount, 2),
            'INR' => '₹' . number_format($amount, 2),
            default => number_format($amount, 2) . ' ' . $currency,
        };
    }
}


if (!function_exists('shortenTitle')) {
    function shortenTitle($title): string
    {
        $titleWords = explode(' ', $title);
        return implode(' ', array_slice($titleWords, 0, 3));
    }
}
