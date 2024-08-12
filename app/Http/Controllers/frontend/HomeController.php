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
        $best_selling_products = Product::query()->bestSelling()->inRandomOrder()->limit(15)->get();
        $top_categories = \App\Models\Category::top()->inRandomOrder()->limit(12)->orderBy('id')->get();
        $featured_categories = \App\Models\Category::featured()->inRandomOrder()->limit(11)->orderBy('id')->get();
        return view('frontend.welcome', compact( 'top_products', 'best_selling_products', 'top_categories', 'featured_categories'));
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

    public function getPalletProducts($offerPoolId = 218866357)
    {
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerPoolQueryParam' => json_encode([
                'offerPoolId' => $offerPoolId,
                'taskId' => 1001,
                'language' => 'en',
                'pageNo' => '1',
                'pageSize' => '20'
            ]),
        ];
        return $alibaba->getPalletProducts($params);
    }

    public function categories(Request $request)
    {
        $categories = Category::paginate(20);
        return view('frontend.categories', compact('categories'));
    }


    public function staticPages($slug)
    {
        return view('frontend.static_pages.' . $slug);
    }

}
