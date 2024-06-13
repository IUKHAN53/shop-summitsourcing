<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::limit(11)->get();
        return view('frontend.welcome', compact('categories'));
    }

    public function searchProducts(Request $request)
    {
        $searchTerm = $request->search;
        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'pageSize' => 15,
                'beginPage' => 1,
                'country' => 'en'
            ]),
        ];
        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'];
        return view('frontend.products_list', compact('products', 'searchTerm', 'total_records', 'pages'));
    }
}
