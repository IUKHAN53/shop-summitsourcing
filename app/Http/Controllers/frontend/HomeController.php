<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $category = Category::query()->inRandomOrder()->first();
        $api_top_products = $this->getTopProducts($category->alibaba_id)['result']['result'];
        $top_products = [];
        if(!isset($api_top_products['rankProductModels'])){
            $category = Category::query()->inRandomOrder()->first();
            $api_top_products = $this->getTopProducts($category->alibaba_id)['result']['result'];
            $top_products = [];
        }
        foreach ($api_top_products['rankProductModels'] as $product) {
            $top_products[] = [
                'item_id' => $product['itemId'],
                'image' => $product['imgUrl'],
                'title' => $product['translateTitle'],
                'service' => $product['serviceList'] ? $product['serviceList'][0] : '',
                'rating' => $product['goodsScore'] ?? 0,
                'width' => isset( $product['goodsScore'] ) ? calculateWidth($product['goodsScore']) : 0,
                'sold' => $category->soldOut,
                'category' => $category->name,
            ];
        }

        $api_best_deals = $this->getBestDeals($category->alibaba_id)['result']['result'];
        $best_deals = [];
        foreach ($api_best_deals['rankProductModels'] as $product) {
            $best_deals[] = [
                'item_id' => $product['itemId'],
                'image' => $product['imgUrl'],
                'title' => $product['translateTitle'],
                'service' => $product['serviceList'] ? $product['serviceList'][0] : '',
                'rating' => $product['goodsScore'] ?? 0,
                'width' => isset( $product['goodsScore'] ) ? calculateWidth($product['goodsScore']) : 0,
                'sold' => $category->soldOut,
                'category' => $category->name,
            ];
        }
        $categories = \App\Models\Category::limit(11)->get();
        return view('frontend.welcome', compact('categories', 'top_products','best_deals'));
    }

    public function getTopProducts($catId = null)
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'rankQueryParams' => json_encode([
                'rankId' => $catId,
                'rankType' => 'hot',
                'limit' => 10,
                'language' => 'en'
            ]),
        ];
        return $alibaba->getTopRankProducts($params);
    }

    public function getBestDeals($catId = null)
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'rankQueryParams' => json_encode([
                'rankId' => $catId,
                'rankType' => 'goodPrice',
                'limit' => 6,
                'language' => 'en'
            ]),
        ];
        return $alibaba->getTopRankProducts($params);
    }

    public function staticPages($slug)
    {
        return view('frontend.static_pages.' . $slug);
    }

}
