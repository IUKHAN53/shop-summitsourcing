<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $top_products = Product::query()->trending()->inRandomOrder()->limit(15)->get();
        $best_selling_products = Product::query()->best_selling()->inRandomOrder()->limit(15)->get();
        $categories = \App\Models\Category::limit(11)->get();
        return view('frontend.welcome', compact('categories', 'top_products', 'best_selling_products'));
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

    public function getRecommendedProducts()
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'recommendOfferParam' => json_encode([
                'beginPage' => 1,
                'pageSize' => 10,
                'country' => 'en',
                'outMemberId' => 'tb14132031'
            ]),
        ];
        return $alibaba->getRecommendedProducts($params);
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

    public function getPalletProducts()
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => 218866357,
                'taskId' => 1001,
                'language' => 'en',
                'pageNo' => '1',
                'pageSize' => '20'
            ]),
        ];
        return $alibaba->getPalletProducts($params);
    }


    public function staticPages($slug)
    {
        return view('frontend.static_pages.' . $slug);
    }

}
