<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExchangeRate;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getDetails($id)
    {
        return view('frontend.product_detail', compact('id'));
    }


    public function searchProducts(Request $request)
    {
        if ($request->file('image')) {
            $alibaba = new \App\Services\AlibabaService();
            $file = base64_encode(file_get_contents($request->file('image')));
            $params = [
                'uploadImageParam' => json_encode([
                    'imageBase64' => $file,
                ]),
            ];
            $result = $alibaba->uploadImage($params);
            $data = $result;
            dd($data);
        }

        $searchTerm = $request->input('search');
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort');
        $orderBy = [];
        if ($sort != 'default') {
            $orderBy = [
                'price' => $sort
            ];
        }
        $type = $request->input('type', 'all');
        $type = $type == 'dropshipping' ? 'isSelect' : 'isQqyx';

        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'filter' => $type,
                'pageSize' => $pageSize,
                'beginPage' => $page,
                'country' => 'en',
                $sort != 'default' ? 'sort' : '' => json_encode($orderBy)
            ]),
        ];

        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'] ?? [];

        return view('frontend.products_list', compact('products', 'searchTerm', 'total_records', 'pages', 'page', 'pageSize', 'sort'));
    }




    public function getPalletProducts(Request $request)
    {
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort', 'asc');
        $orderBy = $request->input('orderBy', 'price');
        $search = $request->input('search', '');

        $query = Product::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy($orderBy, $sort)->paginate($pageSize);

        return view('frontend.pallet_products', compact('products', 'sort', 'orderBy', 'search'));
    }

    public function searchDropshippingProducts(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 15);
        $sort = $request->input('sort');
        $orderBy = [];
        if ($sort != 'default') {
            $orderBy = [
                'price' => $sort
            ];
        }

        $alibaba = new \App\Services\AlibabaService();
        $params = [
            'offerQueryParam' => json_encode([
                'keyword' => $searchTerm,
                'filter' => 'isSelect',
                'pageSize' => $pageSize,
                'beginPage' => $page,
                'country' => 'en',
                $sort != 'default' ? 'sort' : '' => json_encode($orderBy)
            ]),
        ];

        $result = $alibaba->searchProductsByKeyword($params);
        $data = $result['result']['result'];
        $total_records = $data['totalRecords'];
        $pages = $data['totalPage'];
        $products = $data['data'];

        return view('frontend.dropshipping', compact('products', 'searchTerm', 'total_records', 'pages', 'page', 'pageSize', 'sort'));
    }

}
